<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site webmanifest
    |--------------------------------------------------------------------------
    |
    | Webmanifest is a JSON file used by Android devices to look for some 
    | parameters (favicon, theme color, long and short name of your application) 
    | in order to display your application properly on your mobile or tablet 
    | device
    |
    */

    'site-webmanifest' => [

        'name' => env('APP_NAME', 'Laravel'),
        'short_name' => env('APP_NAME', 'Laravel'),
        'start_url' => env('APP_URL', 'http://localhost'),
        'display' => 'standalone',
        'background_color' => '#ffffff',

    ],

    /**
     * Environment for which to show the favicon on.
     */

    'environments' => ['staging', 'production'],

];
