<?php
// Cozy Vibes Radio - PHP Edition
// Basic configuration
return [
    'site_name' => 'Cozy Vibes Radio',
    'base_url'  => 'http://104.248.0.226',
    'env'       => 'production',
    'locale_default' => 'ro',
    'locales' => ['ro','en','es','fr','de'],
    'assets_version' => '1762898770',
    // security
    'jwt_secret' => 'change_this_secret_key_please',
    // storage
    'data_dir' => __DIR__ . '/../data',
];
