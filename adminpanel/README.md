# Kannada Calendar Admin Panel

A modern PHP admin panel for managing the Kannada Calendar Flutter app settings, specifically for the Seven Days Challenge page.

## Features

- 🔐 Secure login system
- 🎛️ Toggle Interstitial Ads on/off
- 🎛️ Toggle Reward Ads on/off
- 📺 Manage YouTube video link
- 🌐 Manage separate website links:
  - Redeem Website Link (for "ಉಚಿತ ಕನ್ನಡ ಕ್ಯಾಲೆಂಡರ್ ಪಡೆಯಿರಿ" button)
  - Visit Website Link (for "ವೆಬ್‌ಸೈಟ್‌ಗೆ ಭೇಟಿ ನೀಡಿ" button)
- 📡 RESTful API endpoint for Flutter app
- 🎨 Modern, responsive design
- 💾 JSON-based configuration storage

## Setup Instructions

### 1. File Permissions

Make sure the following files are writable by the web server:
```bash
chmod 666 config.json
chmod 644 .htaccess
```

### 2. Create Credentials File

Create a file named `credentials.json` in the adminpanel directory with the following structure:

```json
{
  "username": "admin",
  "password": "your_secure_password_here"
}
```

**Important:** Change the default username and password immediately after setup!

### 3. Server Requirements

- PHP 7.0 or higher
- Apache web server with mod_rewrite enabled (for .htaccess)
- Write permissions for the `config.json` file

### 4. Upload Files

Upload all files to your server at: `https://kannadacalendar.in/app/adminpanel`

### 5. Access the Admin Panel

Navigate to: `https://kannadacalendar.in/app/adminpanel`

Default credentials (change immediately):
- Username: `admin`
- Password: `admin123`

## API Endpoint

The Flutter app can fetch settings from:

```
GET https://kannadacalendar.in/app/adminpanel/api.php
```

### API Response Format

```json
{
  "interstitial_ad_enabled": true,
  "reward_ad_enabled": true,
  "youtube_link": "gsIkR1Jiltw",
  "redeem_website_link": "https://kannadacalendar.in/",
  "visit_website_link": "https://kannadacalendar.in/",
  "last_updated": "2024-01-01 12:00:00",
  "status": "success"
}
```

## File Structure

```
adminpanel/
├── index.php          # Login page
├── dashboard.php      # Main admin dashboard
├── api.php            # API endpoint for Flutter app
├── logout.php         # Logout handler
├── config.json        # Configuration storage (auto-generated)
├── credentials.json   # Login credentials (create this file)
├── .htaccess          # Security and CORS settings
├── README.md          # This file
└── assets/
    ├── css/
    │   └── style.css  # Stylesheet
    └── js/
        └── script.js  # JavaScript functionality
```

## Security Notes

1. **Change Default Credentials:** Immediately change the default username and password in `credentials.json`
2. **File Permissions:** Ensure `config.json` and `credentials.json` are not publicly accessible (protected by .htaccess)
3. **HTTPS:** Always use HTTPS in production
4. **Regular Backups:** Backup `config.json` regularly

## Usage

### Managing Settings

1. Log in to the admin panel
2. Toggle ad settings using the switches
3. Enter YouTube video ID or full URL
4. Enter website URL
5. Click "Save Settings"

### YouTube Link Format

You can enter either:
- Video ID: `gsIkR1Jiltw`
- Full URL: `https://www.youtube.com/watch?v=gsIkR1Jiltw`

The system will automatically extract the video ID.

### Website Links Format

Both website links must be valid URLs starting with `http://` or `https://`:
- **Redeem Website Link**: Used by "ಉಚಿತ ಕನ್ನಡ ಕ್ಯಾಲೆಂಡರ್ ಪಡೆಯಿರಿ" button
- **Visit Website Link**: Used by "ವೆಬ್‌ಸೈಟ್‌ಗೆ ಭೇಟಿ ನೀಡಿ" button

You can set different URLs for each button to direct users to different pages.

## Troubleshooting

### Cannot save settings
- Check file permissions on `config.json`
- Ensure PHP has write access to the directory

### API returns error
- Verify `config.json` exists and is valid JSON
- Check file permissions

### Login not working
- Ensure `credentials.json` exists with valid JSON structure
- Check file permissions

## Support

For issues or questions, please contact the development team.

