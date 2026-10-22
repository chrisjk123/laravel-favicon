<?php

namespace Chriscreates\Favicon\Tests;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

class GenerateFaviconImagesTest extends TestCase
{
    #[Test]
    public function the_command_runs_without_failure()
    {
        $this->artisan('favicon:generate')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_generates_resized_favicons_from_the_png()
    {
        imagepng(imagecreatetruecolor(1024, 1024), public_path('favicon.png'));

        $this->beforeApplicationDestroyed(fn () => File::delete([
            public_path('favicon.png'),
            public_path('apple-touch-icon.png'),
            public_path('site.webmanifest'),
            ...File::glob(public_path('android-chrome-*.png')),
            ...File::glob(public_path('favicon-*.png')),
            ...File::glob(public_path('mstile-*.png')),
        ]));

        $this->artisan('favicon:generate')
            ->assertExitCode(0);

        $this->assertSame([32, 32], array_slice(getimagesize(public_path('favicon-32x32.png')), 0, 2));
        $this->assertSame([150, 150], array_slice(getimagesize(public_path('mstile-310x150.png')), 0, 2));
        $this->assertSame([512, 512], array_slice(getimagesize(public_path('android-chrome-512x512.png')), 0, 2));
        $this->assertFileExists(public_path('site.webmanifest'));
    }
}
