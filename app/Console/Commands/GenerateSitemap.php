<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate {--url= : Override the application URL for the sitemap}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a static sitemap.xml file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = $this->option('url');
        if ($url) {
            config(['app.url' => rtrim($url, '/')]);
            URL::forceRootUrl($url);
            if (str_starts_with($url, 'https')) {
                URL::forceScheme('https');
            }
            $this->info("Setting APP_URL to: " . config('app.url'));
        }

        $this->info('Generating sitemap...');

        $products = Product::where('is_active', true)->latest()->get();
        $categories = Category::where('is_active', true)->get();

        $content = view('themes.default.sitemap', compact('products', 'categories'))->render();

        $path = public_path('sitemap.xml');
        File::put($path, $content);

        $this->info("Sitemap generated successfully at: {$path}");
        
        return Command::SUCCESS;
    }
}
