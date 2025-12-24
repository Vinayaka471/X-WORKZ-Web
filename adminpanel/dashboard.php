<?php
session_start();

// Check if logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$configFile = __DIR__ . '/config.json';
$success = '';
$error = '';

// Load current config
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
    'last_updated' => date('Y-m-d H:i:s')
];

if (file_exists($configFile)) {
    $config = array_merge($config, json_decode(file_get_contents($configFile), true));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $config['interstitial_ad_enabled'] = isset($_POST['interstitial_ad_enabled']) ? true : false;
    $config['reward_ad_enabled'] = isset($_POST['reward_ad_enabled']) ? true : false;
    $config['youtube_link'] = trim($_POST['youtube_link'] ?? '');
    $config['redeem_website_link'] = trim($_POST['redeem_website_link'] ?? '');
    $config['visit_website_link'] = trim($_POST['visit_website_link'] ?? '');
    $config['create_and_earn_link'] = trim($_POST['create_and_earn_link'] ?? '');
    $config['slider_items'] = [
        [
            'title' => trim($_POST['slider1_title'] ?? ''),
            'image_url' => trim($_POST['slider1_image'] ?? ''),
        ],
        [
            'title' => trim($_POST['slider2_title'] ?? ''),
            'image_url' => trim($_POST['slider2_image'] ?? ''),
        ],
        [
            'title' => trim($_POST['slider3_title'] ?? ''),
            'image_url' => trim($_POST['slider3_image'] ?? ''),
        ],
    ];
    $config['last_updated'] = date('Y-m-d H:i:s');
    
    // Extract YouTube video ID if full URL is provided
    if (!empty($config['youtube_link'])) {
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $config['youtube_link'], $matches)) {
            $config['youtube_link'] = $matches[1];
        }
    }
    
    // Validate website links and slider images
    if (!empty($config['redeem_website_link']) && !filter_var($config['redeem_website_link'], FILTER_VALIDATE_URL)) {
        $error = 'Invalid redeem website URL format';
    } elseif (!empty($config['visit_website_link']) && !filter_var($config['visit_website_link'], FILTER_VALIDATE_URL)) {
        $error = 'Invalid visit website URL format';
    } elseif (!empty($config['create_and_earn_link']) && !filter_var($config['create_and_earn_link'], FILTER_VALIDATE_URL)) {
        $error = 'Invalid create and earn website URL format';
    } elseif (!empty($config['slider_items'][0]['image_url']) && !filter_var($config['slider_items'][0]['image_url'], FILTER_VALIDATE_URL)) {
        $error = 'Invalid Slider 1 image URL';
    } elseif (!empty($config['slider_items'][1]['image_url']) && !filter_var($config['slider_items'][1]['image_url'], FILTER_VALIDATE_URL)) {
        $error = 'Invalid Slider 2 image URL';
    } elseif (!empty($config['slider_items'][2]['image_url']) && !filter_var($config['slider_items'][2]['image_url'], FILTER_VALIDATE_URL)) {
        $error = 'Invalid Slider 3 image URL';
    } else {
        if (file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT))) {
            $success = 'Settings saved successfully!';
        } else {
            $error = 'Failed to save settings. Please check file permissions.';
        }
    }
    
    // Reload config after save
    if (file_exists($configFile)) {
        $config = array_merge($config, json_decode(file_get_contents($configFile), true));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kannada Calendar</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <div class="header-content">
                <div class="header-left">
                    <div class="logo-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 4H5C3.89 4 3 4.9 3 6V20C3 21.1 3.89 22 5 22H19C20.1 22 21 21.1 21 20V6C21 4.9 20.1 4 19 4ZM19 20H5V9H19V20ZM7 11H9V13H7V11ZM11 11H13V13H11V11ZM15 11H17V13H15V11ZM7 15H9V17H7V15ZM11 15H13V17H11V15ZM15 15H17V17H15V15Z" fill="currentColor"/>
                        </svg>
                    </div>
                    <div>
                        <h1>Kannada Calendar</h1>
                        <p>Admin Dashboard</p>
                    </div>
                </div>
                <div class="header-right">
                    <a href="api.php" target="_blank" class="btn btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="currentColor"/>
                        </svg>
                        View API
                    </a>
                    <a href="logout.php" class="btn btn-outline">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 7L15.59 8.41L18.17 11H8V13H18.17L15.59 15.59L17 17L22 12L17 7ZM4 5H12V3H4C2.9 3 2 3.9 2 5V19C2 20.1 2.9 21 4 21H12V19H4V5Z" fill="currentColor"/>
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
        </header>

        <main class="dashboard-main">
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 16.17L4.83 12L3.41 13.41L9 19L21 7L19.59 5.59L9 16.17Z" fill="currentColor"/>
                    </svg>
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="currentColor"/>
                    </svg>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="settings-form">
                <div class="settings-grid">
                    <!-- Ad Settings Card -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4ZM20 18H4V6H20V18ZM7.5 13.5L9 11.5L11.5 14.5L15.5 9.5L18.5 13.5H7.5Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div>
                                <h2>Advertisement Settings</h2>
                                <p>Control ad display for Seven Days Challenge</p>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="toggle-group">
                                <div class="toggle-item">
                                    <div class="toggle-info">
                                        <h3>Interstitial Ads</h3>
                                        <p>Show full-screen ads after scratching cards</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="interstitial_ad_enabled" <?php echo $config['interstitial_ad_enabled'] ? 'checked' : ''; ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div class="toggle-item">
                                    <div class="toggle-info">
                                        <h3>Reward Ads</h3>
                                        <p>Show rewarded video ads for extra benefits</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="reward_ad_enabled" <?php echo $config['reward_ad_enabled'] ? 'checked' : ''; ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- YouTube Link Card -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon youtube-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 16.5L16 12L10 7.5V16.5ZM21.56 7.17C21.69 7.64 21.78 8.27 21.84 9.07C21.91 9.87 21.94 10.56 21.94 11.16L22 12C22 14.19 21.84 15.8 21.56 16.83C21.31 17.73 20.73 18.31 19.83 18.56C19.36 18.69 18.5 18.78 17.18 18.84C15.88 18.91 14.69 18.94 13.59 18.94L12 19C7.81 19 5.2 18.84 4.17 18.56C3.27 18.31 2.69 17.73 2.44 16.83C2.31 16.36 2.22 15.73 2.16 14.93C2.09 14.13 2.06 13.44 2.06 12.84L2 12C2 9.81 2.16 8.2 2.44 7.17C2.69 6.27 3.27 5.69 4.17 5.44C4.64 5.31 5.5 5.22 6.82 5.16C8.12 5.09 9.31 5.06 10.41 5.06L12 5C16.19 5 18.8 5.16 19.83 5.44C20.73 5.69 21.31 6.27 21.56 7.17Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div>
                                <h2>YouTube Video</h2>
                                <p>Set the YouTube video for Seven Days Challenge</p>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group">
                                <label for="youtube_link">YouTube Video ID or URL</label>
                                <div class="input-wrapper">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 16.5L16 12L10 7.5V16.5ZM21.56 7.17C21.69 7.64 21.78 8.27 21.84 9.07C21.91 9.87 21.94 10.56 21.94 11.16L22 12C22 14.19 21.84 15.8 21.56 16.83C21.31 17.73 20.73 18.31 19.83 18.56C19.36 18.69 18.5 18.78 17.18 18.84C15.88 18.91 14.69 18.94 13.59 18.94L12 19C7.81 19 5.2 18.84 4.17 18.56C3.27 18.31 2.69 17.73 2.44 16.83C2.31 16.36 2.22 15.73 2.16 14.93C2.09 14.13 2.06 13.44 2.06 12.84L2 12C2 9.81 2.16 8.2 2.44 7.17C2.69 6.27 3.27 5.69 4.17 5.44C4.64 5.31 5.5 5.22 6.82 5.16C8.12 5.09 9.31 5.06 10.41 5.06L12 5C16.19 5 18.8 5.16 19.83 5.44C20.73 5.69 21.31 6.27 21.56 7.17Z" fill="currentColor"/>
                                    </svg>
                                    <input type="text" id="youtube_link" name="youtube_link" value="<?php echo htmlspecialchars($config['youtube_link']); ?>" placeholder="gsIkR1Jiltw or https://youtube.com/watch?v=...">
                                </div>
                                <small>Enter YouTube video ID (e.g., gsIkR1Jiltw) or full URL</small>
                            </div>
                        </div>
                    </div>

                    <!-- Redeem Website Link Card -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon website-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div>
                                <h2>Redeem Website Link</h2>
                                <p>Link for "ಉಚಿತ ಕನ್ನಡ ಕ್ಯಾಲೆಂಡರ್ ಪಡೆಯಿರಿ" button</p>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group">
                                <label for="redeem_website_link">Redeem Website URL</label>
                                <div class="input-wrapper">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.9 12C3.9 10.29 4.98 8.9 6.4 8.09L4.9 5.5C3.01 6.77 1.9 9.26 1.9 12C1.9 14.74 3.01 17.23 4.9 18.5L6.4 15.91C4.98 15.1 3.9 13.71 3.9 12ZM17.6 15.91L19.1 18.5C20.99 17.23 22.1 14.74 22.1 12C22.1 9.26 20.99 6.77 19.1 5.5L17.6 8.09C19.02 8.9 20.1 10.29 20.1 12C20.1 13.71 19.02 15.1 17.6 15.91ZM19.1 5.5L17.6 8.09C15.74 7.38 13.92 7.38 12.06 8.09L10.56 5.5C13.26 4.24 16.4 4.24 19.1 5.5ZM10.56 18.5L12.06 15.91C13.92 16.62 15.74 16.62 17.6 15.91L19.1 18.5C16.4 19.76 13.26 19.76 10.56 18.5ZM8.8 12C8.8 13.77 10.23 15.2 12 15.2C13.77 15.2 15.2 13.77 15.2 12C15.2 10.23 13.77 8.8 12 8.8C10.23 8.8 8.8 10.23 8.8 12Z" fill="currentColor"/>
                                    </svg>
                                    <input type="url" id="redeem_website_link" name="redeem_website_link" value="<?php echo htmlspecialchars($config['redeem_website_link'] ?? 'https://kannadacalendar.in/'); ?>" placeholder="https://kannadacalendar.in/">
                                </div>
                                <small>Enter the full website URL for redeem code button (must start with http:// or https://)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Visit Website Link Card -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon website-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div>
                                <h2>Visit Website Link</h2>
                                <p>Link for "ವೆಬ್‌ಸೈಟ್‌ಗೆ ಭೇಟಿ ನೀಡಿ" button</p>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group">
                                <label for="visit_website_link">Visit Website URL</label>
                                <div class="input-wrapper">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.9 12C3.9 10.29 4.98 8.9 6.4 8.09L4.9 5.5C3.01 6.77 1.9 9.26 1.9 12C1.9 14.74 3.01 17.23 4.9 18.5L6.4 15.91C4.98 15.1 3.9 13.71 3.9 12ZM17.6 15.91L19.1 18.5C20.99 17.23 22.1 14.74 22.1 12C22.1 9.26 20.99 6.77 19.1 5.5L17.6 8.09C19.02 8.9 20.1 10.29 20.1 12C20.1 13.71 19.02 15.1 17.6 15.91ZM19.1 5.5L17.6 8.09C15.74 7.38 13.92 7.38 12.06 8.09L10.56 5.5C13.26 4.24 16.4 4.24 19.1 5.5ZM10.56 18.5L12.06 15.91C13.92 16.62 15.74 16.62 17.6 15.91L19.1 18.5C16.4 19.76 13.26 19.76 10.56 18.5ZM8.8 12C8.8 13.77 10.23 15.2 12 15.2C13.77 15.2 15.2 13.77 15.2 12C15.2 10.23 13.77 8.8 12 8.8C10.23 8.8 8.8 10.23 8.8 12Z" fill="currentColor"/>
                                    </svg>
                                    <input type="url" id="visit_website_link" name="visit_website_link" value="<?php echo htmlspecialchars($config['visit_website_link'] ?? 'https://kannadacalendar.in/'); ?>" placeholder="https://kannadacalendar.in/">
                                </div>
                                <small>Enter the full website URL for visit website button (must start with http:// or https://)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Create and Earn Website Link Card -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon website-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div>
                                <h2>Create and Earn Website Link</h2>
                                <p>Link for "ಕ್ರಿಯೇಟ್ ಅಂಡ್ ಅರ್ನ್" button</p>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group">
                                <label for="create_and_earn_link">Create and Earn Website URL</label>
                                <div class="input-wrapper">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.9 12C3.9 10.29 4.98 8.9 6.4 8.09L4.9 5.5C3.01 6.77 1.9 9.26 1.9 12C1.9 14.74 3.01 17.23 4.9 18.5L6.4 15.91C4.98 15.1 3.9 13.71 3.9 12ZM17.6 15.91L19.1 18.5C20.99 17.23 22.1 14.74 22.1 12C22.1 9.26 20.99 6.77 19.1 5.5L17.6 8.09C19.02 8.9 20.1 10.29 20.1 12C20.1 13.71 19.02 15.1 17.6 15.91ZM19.1 5.5L17.6 8.09C15.74 7.38 13.92 7.38 12.06 8.09L10.56 5.5C13.26 4.24 16.4 4.24 19.1 5.5ZM10.56 18.5L12.06 15.91C13.92 16.62 15.74 16.62 17.6 15.91L19.1 18.5C16.4 19.76 13.26 19.76 10.56 18.5ZM8.8 12C8.8 13.77 10.23 15.2 12 15.2C13.77 15.2 15.2 13.77 15.2 12C15.2 10.23 13.77 8.8 12 8.8C10.23 8.8 8.8 10.23 8.8 12Z" fill="currentColor"/>
                                    </svg>
                                    <input type="url" id="create_and_earn_link" name="create_and_earn_link" value="<?php echo htmlspecialchars($config['create_and_earn_link'] ?? 'https://kannadacalendar.in/'); ?>" placeholder="https://kannadacalendar.in/">
                                </div>
                                <small>Enter the full website URL for create and earn button (must start with http:// or https://)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Slider Settings Card -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 6H2V18H4V6ZM14 6H10V18H14V6ZM22 6H20V18H22V6Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div>
                                <h2>Home Slider</h2>
                                <p>Images and text for the home page slider (3 slides)</p>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php
                            $slider = $config['slider_items'] ?? [];
                            $slider1 = $slider[0] ?? ['title' => '', 'image_url' => ''];
                            $slider2 = $slider[1] ?? ['title' => '', 'image_url' => ''];
                            $slider3 = $slider[2] ?? ['title' => '', 'image_url' => ''];
                            ?>
                            <div class="form-group">
                                <label>Slide 1 Image URL</label>
                                <div class="input-wrapper">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 19V5C21 3.9 20.1 3 19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19ZM8.5 13.5L11 16.51L14.5 12L19 18H5L8.5 13.5Z" fill="currentColor"/>
                                    </svg>
                                    <input type="url" name="slider1_image" value="<?php echo htmlspecialchars($slider1['image_url']); ?>" placeholder="https://.../1.png">
                                </div>
                                <small>Background image URL for Slide 1</small>
                            </div>
                            <div class="form-group">
                                <label>Slide 1 Text</label>
                                <input type="text" name="slider1_title" value="<?php echo htmlspecialchars($slider1['title']); ?>" placeholder="Slide 1 text">
                            </div>

                            <hr>

                            <div class="form-group">
                                <label>Slide 2 Image URL</label>
                                <div class="input-wrapper">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 19V5C21 3.9 20.1 3 19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19ZM8.5 13.5L11 16.51L14.5 12L19 18H5L8.5 13.5Z" fill="currentColor"/>
                                    </svg>
                                    <input type="url" name="slider2_image" value="<?php echo htmlspecialchars($slider2['image_url']); ?>" placeholder="https://.../2.png">
                                </div>
                                <small>Background image URL for Slide 2</small>
                            </div>
                            <div class="form-group">
                                <label>Slide 2 Text</label>
                                <input type="text" name="slider2_title" value="<?php echo htmlspecialchars($slider2['title']); ?>" placeholder="Slide 2 text">
                            </div>

                            <hr>

                            <div class="form-group">
                                <label>Slide 3 Image URL</label>
                                <div class="input-wrapper">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 19V5C21 3.9 20.1 3 19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19ZM8.5 13.5L11 16.51L14.5 12L19 18H5L8.5 13.5Z" fill="currentColor"/>
                                    </svg>
                                    <input type="url" name="slider3_image" value="<?php echo htmlspecialchars($slider3['image_url']); ?>" placeholder="https://.../3.png">
                                </div>
                                <small>Background image URL for Slide 3</small>
                            </div>
                            <div class="form-group">
                                <label>Slide 3 Text</label>
                                <input type="text" name="slider3_title" value="<?php echo htmlspecialchars($slider3['title']); ?>" placeholder="Slide 3 text">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 16.17L4.83 12L3.41 13.41L9 19L21 7L19.59 5.59L9 16.17Z" fill="currentColor"/>
                        </svg>
                        Save Settings
                    </button>
                </div>
            </form>

            <div class="info-card">
                <div class="info-header">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="currentColor"/>
                    </svg>
                    <h3>API Information</h3>
                </div>
                <p>Your Flutter app can fetch these settings from: <code><?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/api.php'; ?></code></p>
                <p class="last-updated">Last updated: <strong><?php echo htmlspecialchars($config['last_updated']); ?></strong></p>
            </div>
        </main>
    </div>
    <script src="assets/js/script.js"></script>
</body>
</html>

