<?php

namespace Chriscreates\Favicon\Tests;

class GenerateFaviconImagesTest extends TestCase
{
    /** @test */
    public function the_command_runs_without_failure()
    {
        $this->artisan('favicon:generate')
            ->assertExitCode(0);
    }
}
