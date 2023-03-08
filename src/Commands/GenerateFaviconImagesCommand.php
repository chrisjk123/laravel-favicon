<?php

namespace App\Console\Commands;

use DOMDocument;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

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

        try {
            $imgFile = Image::make(public_path($pngPath));
        } catch (Exception $e) {
            $this->error('Opps, looks like that is not a valid .png');

            return;
        }

        $imgFile->resize(192, 192, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('android-chrome-192x192.png'));

        $imgFile->resize(384, 384, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('android-chrome-384x384.png'));

        $imgFile->resize(512, 512, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('android-chrome-512x512.png'));

        $imgFile->resize(180, 180, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('apple-touch-icon.png'));

        $imgFile->resize(16, 16, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('favicon-16x16.png'));

        $imgFile->resize(32, 32, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('favicon-32x32.png'));

        $imgFile->resize(48, 48, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('favicon-48x48.png'));

        $imgFile->resize(70, 70, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('mstile-70x70.png'));

        $imgFile->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('mstile-150x150.png'));

        $imgFile->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('mstile-150x150.png'));

        $imgFile->resize(310, 150, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('mstile-310x150.png'));

        $imgFile->resize(310, 310, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('mstile-310x310.png'));

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

        // favicon.ico

        if ($svg = $this->option('svg')) {
            $dom = new DOMDocument('1.0', 'utf-8');
            $dom->load(public_path($svg));
            $svg = $dom->documentElement;

            $svg->setAttribute('width', '16');
            $svg->setAttribute('height', '16');
            $dom->save(public_path('safari-pinned-tab.svg'));
        }

        $this->info('All done!');
    }
}
