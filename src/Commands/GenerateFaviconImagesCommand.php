<?php

namespace Chriscreates\Favicon\Commands;

use DOMDocument;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class GenerateFaviconImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'favicon:generate
                            {--png=favicon.png : Path to the favicon png}
                            {--svg=favicon.svg : Path to the favicon svg}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A command to generate favicons';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Start creating Favicons...');

        $pngPath = $this->option('png');
        $imagePath = public_path($pngPath);

        try {
            $manager = new ImageManager(new Driver());
            $manager->read($imagePath);
        } catch (Exception $e) {
            $this->error("[{$imagePath}] is not a valid .png");

            return;
        }

        $sizes = [
            'android-chrome-192x192.png' => [192, 192],
            'android-chrome-384x384.png' => [384, 384],
            'android-chrome-512x512.png' => [512, 512],
            'apple-touch-icon.png' => [180, 180],
            'favicon-16x16.png' => [16, 16],
            'favicon-32x32.png' => [32, 32],
            'favicon-48x48.png' => [48, 48],
            'mstile-70x70.png' => [70, 70],
            'mstile-150x150.png' => [150, 150],
            'mstile-310x150.png' => [310, 150],
            'mstile-310x310.png' => [310, 310],
        ];

        foreach ($sizes as $filename => [$width, $height]) {
            $manager->read($imagePath)
                ->scale($width, $height)
                ->save(public_path($filename));
        }

        $siteWebmanifestConfig = config()->get('favicon.site-webmanifest');

        $siteWebmanifestJson = [
            'name' => $siteWebmanifestConfig['name'],
            'short_name' => $siteWebmanifestConfig['short_name'],
            'start_url' => $siteWebmanifestConfig['start_url'],
            'display' => $siteWebmanifestConfig['display'],
            'background_color' => $siteWebmanifestConfig['background_color'],
            'icons' => [
                [
                    'src' => '/android-chrome-192x192.png',
                    'sizes' => '192x192',
                    'type' => 'image/png',
                ],
                [
                    'src' => '/android-chrome-512x512.png',
                    'sizes' => '512x512',
                    'type' => 'image/png',
                ],
            ],
        ];

        File::put(
            public_path('site.webmanifest'),
            json_encode($siteWebmanifestJson, JSON_PRETTY_PRINT),
        );

        if (File::exists(public_path($this->option('svg')))) {
            $dom = new DOMDocument('1.0', 'utf-8');
            $dom->load(public_path($this->option('svg')));
            $svg = $dom->documentElement;

            $svg->setAttribute('width', '16');
            $svg->setAttribute('height', '16');
            $dom->save(public_path('safari-pinned-tab.svg'));
        }

        $this->info('All done!');
    }
}
