<?php

return [
    'high_value_url_patterns' => [
        '/pricing',
        '/checkout',
        '/contact',
        '/demo',
        '/enterprise',
        '/quote',
    ],

    'high_value_page_bonus' => 30,

    'scoring' => [
        'max_time_points' => 40,
        'points_per_minute' => 5,
        'visit_bonus' => [
            2 => 8,
            3 => 15,
            5 => 25,
        ],
    ],

    'live_feed_minutes' => 30,

    /** Kur true, bizneset e regjistruara identifikohen menjëherë në tracking */
    'auto_verify_registrations' => env('IPKO_AUTO_VERIFY_BUSINESSES', true),
];
