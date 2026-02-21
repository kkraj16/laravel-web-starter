<?php

namespace App\Core\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class InstallerController extends Controller
{
    /**
     * Step 1: Welcome page
     */
    public function welcome()
    {
        return view('installer.welcome');
    }

    /**
     * Step 2: Check server requirements
     */
    public function requirements()
    {
        $phpVersion = PHP_VERSION;
        $phpOk = version_compare($phpVersion, '8.2.0', '>=');

        $extensions = [
            'openssl'  => extension_loaded('openssl'),
            'pdo'      => extension_loaded('pdo'),
            'pdo_mysql'=> extension_loaded('pdo_mysql'),
            'mbstring' => extension_loaded('mbstring'),
            'tokenizer'=> extension_loaded('tokenizer'),
            'xml'      => extension_loaded('xml'),
            'ctype'    => extension_loaded('ctype'),
            'json'     => extension_loaded('json'),
            'bcmath'   => extension_loaded('bcmath'),
            'fileinfo' => extension_loaded('fileinfo'),
            'gd'       => extension_loaded('gd'),
        ];

        $directories = [
            'storage/framework'       => is_writable(storage_path('framework')),
            'storage/logs'            => is_writable(storage_path('logs')),
            'storage/app'             => is_writable(storage_path('app')),
            'bootstrap/cache'         => is_writable(base_path('bootstrap/cache')),
        ];

        $allOk = $phpOk
              && !in_array(false, $extensions, true)
              && !in_array(false, $directories, true);

        return view('installer.requirements', compact(
            'phpVersion', 'phpOk', 'extensions', 'directories', 'allOk'
        ));
    }

    /**
     * Step 3: Environment / database configuration form
     */
    public function environment()
    {
        return view('installer.environment');
    }

    /**
     * Step 3b: Save environment and test DB connection
     */
    public function saveEnvironment(Request $request)
    {
        $request->validate([
            'app_name'    => 'required|string|max:100',
            'app_url'     => 'required|url',
            'db_host'     => 'required',
            'db_port'     => 'required|numeric',
            'db_database' => 'required',
            'db_username' => 'required',
        ]);

        // Test DB connection before saving
        try {
            $pdo = new \PDO(
                "mysql:host={$request->db_host};port={$request->db_port};dbname={$request->db_database}",
                $request->db_username,
                $request->db_password
            );
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Database connection failed: ' . $e->getMessage());
        }

        // Build .env content (preserving existing APP_KEY)
        $env = $this->buildEnvContent($request);
        File::put(base_path('.env'), $env);

        // Update the DB config in memory so the migration step works
        // NOTE: Do NOT call Artisan::call('config:clear') — it crashes the dev server.
        // The redirect will naturally pick up the new .env on the next request.
        config([
            'database.connections.mysql.host'     => $request->db_host,
            'database.connections.mysql.port'     => $request->db_port,
            'database.connections.mysql.database' => $request->db_database,
            'database.connections.mysql.username' => $request->db_username,
            'database.connections.mysql.password' => $request->db_password,
        ]);
        DB::purge('mysql');

        return redirect()->route('installer.migrations');
    }

    /**
     * Step 4: Run migrations and seeders
     */
    public function runMigrations()
    {
        try {
            // Reload DB config from .env file so we use the latest saved values
            $this->reloadDbConfigFromEnv();

            // Generate APP_KEY if not set
            if (empty(config('app.key'))) {
                Artisan::call('key:generate', ['--force' => true]);
            }

            // Run migrations — try normal first, fall back to fresh if tables exist
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Exception $e) {
                // If tables already exist (no migrations table), do a fresh install
                if (str_contains($e->getMessage(), 'already exists')) {
                    Artisan::call('migrate:fresh', ['--force' => true]);
                } else {
                    throw $e; // Re-throw other errors
                }
            }

            // Seed only if tables are empty (first-time setup)
            if (DB::table('roles')->count() === 0) {
                Artisan::call('db:seed', ['--force' => true]);
            }

            // Create storage symlink if missing
            if (!file_exists(public_path('storage'))) {
                Artisan::call('storage:link');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Migration failed: ' . $e->getMessage());
        }

        return redirect()->route('installer.finish');
    }

    /**
     * Reload database config from .env file into memory
     */
    private function reloadDbConfigFromEnv(): void
    {
        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            return;
        }

        $content = File::get($envPath);
        $values = [];
        foreach (explode("\n", $content) as $line) {
            if (str_contains($line, '=') && !str_starts_with(trim($line), '#')) {
                [$key, $value] = explode('=', $line, 2);
                $values[trim($key)] = trim($value, " \t\n\r\0\x0B\"");
            }
        }

        $map = [
            'DB_HOST'     => 'database.connections.mysql.host',
            'DB_PORT'     => 'database.connections.mysql.port',
            'DB_DATABASE' => 'database.connections.mysql.database',
            'DB_USERNAME' => 'database.connections.mysql.username',
            'DB_PASSWORD' => 'database.connections.mysql.password',
        ];

        foreach ($map as $envKey => $configKey) {
            if (isset($values[$envKey])) {
                config([$configKey => $values[$envKey]]);
            }
        }

        DB::purge('mysql');
    }

    /**
     * Step 5: Mark as installed
     */
    public function finish()
    {
        File::put(storage_path('installed'), now()->toDateTimeString());
        return view('installer.finish');
    }

    /**
     * Build .env content from form input, preserving existing APP_KEY
     */
    private function buildEnvContent(Request $request): string
    {
        $appName = str_contains($request->app_name, ' ')
            ? '"' . $request->app_name . '"'
            : $request->app_name;

        // Preserve existing APP_KEY if available
        $existingKey = config('app.key', '');
        if (empty($existingKey)) {
            // Try reading directly from .env file
            $envPath = base_path('.env');
            if (File::exists($envPath)) {
                $content = File::get($envPath);
                if (preg_match('/^APP_KEY=(.+)$/m', $content, $matches)) {
                    $existingKey = trim($matches[1]);
                }
            }
        }

        return implode("\n", [
            "APP_NAME={$appName}",
            "APP_ENV=production",
            "APP_KEY={$existingKey}",
            "APP_DEBUG=false",
            "APP_URL={$request->app_url}",
            "",
            "APP_TIMEZONE=Asia/Kolkata",
            "",
            "LOG_CHANNEL=stack",
            "LOG_STACK=single",
            "LOG_LEVEL=error",
            "",
            "DB_CONNECTION=mysql",
            "DB_HOST={$request->db_host}",
            "DB_PORT={$request->db_port}",
            "DB_DATABASE={$request->db_database}",
            "DB_USERNAME={$request->db_username}",
            "DB_PASSWORD={$request->db_password}",
            "",
            "SESSION_DRIVER=file",
            "SESSION_LIFETIME=120",
            "",
            "CACHE_STORE=file",
            "QUEUE_CONNECTION=sync",
            "FILESYSTEM_DISK=local",
            "",
        ]);
    }
}
