<?php

namespace App\Core\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InstallerController extends Controller
{
    public function welcome()
    {
        return view('installer.welcome');
    }

    public function requirements()
    {
        $requirements = [
            'php' => '8.2.0',
            'extensions' => [
                'openssl',
                'pdo',
                'mbstring',
                'tokenizer',
                'xml',
                'ctype',
                'json',
            ],
        ];

        // Logic to check requirements
        $results = []; // simplified for now

        return view('installer.requirements', compact('results'));
    }

    public function environment()
    {
        return view('installer.environment');
    }

    public function saveEnvironment(Request $request)
    {
        // Validation
        $request->validate([
            'app_name' => 'required',
            'db_host' => 'required',
            'db_port' => 'required',
            'db_database' => 'required',
            'db_username' => 'required',
        ]);

        // Write to .env
        $envContent = File::get(base_path('.env.example'));
        
        $envContent = str_replace('APP_NAME=Laravel', 'APP_NAME="'.$request->app_name.'"', $envContent);
        $envContent = str_replace('DB_HOST=127.0.0.1', 'DB_HOST='.$request->db_host, $envContent);
        $envContent = str_replace('DB_PORT=3306', 'DB_PORT='.$request->db_port, $envContent);
        $envContent = str_replace('DB_DATABASE=laravel', 'DB_DATABASE='.$request->db_database, $envContent);
        $envContent = str_replace('DB_USERNAME=root', 'DB_USERNAME='.$request->db_username, $envContent);
        $envContent = str_replace('DB_PASSWORD=', 'DB_PASSWORD='.$request->db_password, $envContent);

        File::put(base_path('.env'), $envContent);

        return redirect()->route('installer.migrations');
    }

    public function runMigrations()
    {
        // Try to migrate
        try {
            Artisan::call('migrate:fresh', ['--force' => true, '--seed' => true]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('installer.finish');
    }

    public function finish()
    {
        // Mark installed
        File::put(storage_path('installed'), 'true');
        return view('installer.finish');
    }
}
