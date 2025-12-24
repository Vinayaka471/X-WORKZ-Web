<?php
/**
 * Installation script to create credentials.json
 * Run this once, then delete this file for security
 */

// Check if credentials.json already exists
if (file_exists(__DIR__ . '/credentials.json')) {
    die('credentials.json already exists. Delete this install.php file for security.');
}

// Create default credentials
$credentials = [
    'username' => 'admin',
    'password' => 'admin123'
];

// Write credentials file
if (file_put_contents(__DIR__ . '/credentials.json', json_encode($credentials, JSON_PRETTY_PRINT))) {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation Complete</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="success">
        <h2>✅ Installation Complete!</h2>
        <p>credentials.json has been created successfully.</p>
    </div>
    
    <div class="warning">
        <h3>⚠️ Security Warning</h3>
        <p><strong>IMPORTANT:</strong> Please delete this <code>install.php</code> file immediately for security!</p>
        <p>Default credentials:</p>
        <ul>
            <li>Username: <code>admin</code></li>
            <li>Password: <code>admin123</code></li>
        </ul>
        <p><strong>Change these credentials immediately after logging in!</strong></p>
    </div>
    
    <div class="info">
        <h3>📝 Next Steps</h3>
        <ol>
            <li>Delete this <code>install.php</code> file</li>
            <li>Edit <code>credentials.json</code> to change the default password</li>
            <li>Go to <a href="index.php">Login Page</a></li>
        </ol>
    </div>
</body>
</html>';
} else {
    die('Failed to create credentials.json. Please check file permissions.');
}
?>

