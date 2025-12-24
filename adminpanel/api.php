<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$configFile = __DIR__ . '/config.json';

// Default configuration
$config = [
    'interstitial_ad_enabled' => true,
    'reward_ad_enabled' => true,
    'youtube_link' => 'gsIkR1Jiltw',
    'redeem_website_link' => 'https://kannadacalendar.in/',
    'visit_website_link' => 'https://kannadacalendar.in/',
    'create_and_earn_link' => 'https://kannadacalendar.in/',
    'slider_items' => [
        [
            'title' => '',
            'image_url' => 'https://kannadacalendar.in/images/app/1.png',
        ],
        [
            'title' => 'ಉಚಿತ ಮುದ್ರಿತ ಕನ್ನಡ ಕ್ಯಾಲೆಂಡರ್ 2026 ಪಡೆಯಿರಿ',
            'image_url' => 'https://kannadacalendar.in/images/app/2.png',
        ],
        [
            'title' => 'ಪ್ರತಿ ದಿನದ ಪಂಚಾಂಗ, ರಾಶಿ ಭವಿಷ್ಯ ಮತ್ತು ಮುಹೂರ್ತ ಮಾಹಿತಿಯನ್ನು ಪಡೆಯಿರಿ.',
            'image_url' => 'https://kannadacalendar.in/images/app/3.png',
        ],
    ],
    'last_updated' => date('Y-m-d H:i:s'),
    'status' => 'success'
];

// Load configuration from JSON file
if (file_exists($configFile)) {
    $fileConfig = json_decode(file_get_contents($configFile), true);
    if ($fileConfig !== null) {
        $config = array_merge($config, $fileConfig);
        $config['status'] = 'success';
    } else {
        $config['status'] = 'error';
        $config['message'] = 'Invalid configuration file';
    }
} else {
    $config['status'] = 'warning';
    $config['message'] = 'Configuration file not found, using defaults';
}

// Return JSON response
echo json_encode($config, JSON_PRETTY_PRINT);

