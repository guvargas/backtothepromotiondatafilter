<?php

return [
    'name' => 'Badmint',
    'manifest' => [
        'name' => env('APP_NAME', 'Badmint'),
        'short_name' => 'Badmint',
        'start_url' => '/admin',
        'background_color' => '#ffffff',
        'theme_color' => '#2aa151',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '48x48' => [
                'path' => '/img/pwa/icon-48x48.png',
                'purpose' => 'any'
            ],
            '72x72' => [
                'path' => '/img/pwa/icon-72x72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/img/pwa/icon-96x96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/img/pwa/icon-128x128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/img/pwa/icon-144x144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/img/pwa/icon-152x152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/img/pwa/icon-192x192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/img/pwa/icon-384x384.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/img/pwa/icon-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/img/pwa/splash-640x1136.png',
            '750x1334' => '/img/pwa/splash-750x1334.png',
            '828x1792' => '/img/pwa/splash-828x1792.png',
            '1125x2436' => '/img/pwa/splash-1125x2436.png',
            '1242x2208' => '/img/pwa/splash-1242x2208.png',
            '1242x2688' => '/img/pwa/splash-1242x2688.png',
            '1536x2048' => '/img/pwa/splash-1536x2048.png',
            '1668x2224' => '/img/pwa/splash-1668x2224.png',
            '1668x2388' => '/img/pwa/splash-1668x2388.png',
            '2048x2732' => '/img/pwa/splash-2048x2732.png',
        ],
        // 'shortcuts' => [
        //     [
        //         'name' => 'Shortcut Link 1',
        //         'description' => 'Shortcut Link 1 Description',
        //         'url' => '/shortcutlink1',
        //         'icons' => [
        //             "src" => "/img/pwa/icon-72x72.png",
        //             "purpose" => "any"
        //         ]
        //     ],
        //     [
        //         'name' => 'Shortcut Link 2',
        //         'description' => 'Shortcut Link 2 Description',
        //         'url' => '/shortcutlink2'
        //     ]
        // ],
        'custom' => []
    ]
];
