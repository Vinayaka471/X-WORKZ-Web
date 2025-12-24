# Flutter App Integration Guide

This document explains how the Flutter app integrates with the admin panel.

## Overview

The Flutter app fetches settings from the admin panel API and uses them to:
- Control whether interstitial ads are shown
- Control whether reward ads are shown
- Display the correct YouTube video
- Use the correct website link

## How It Works

### 1. Admin Panel Service (`admin_panel_service.dart`)

The app uses `AdminPanelService` to fetch settings from the API:

```dart
final settings = await AdminPanelService.instance.fetchSettings();
```

**Features:**
- Fetches settings from: `https://kannadacalendar.in/app/adminpanel/api.php`
- Caches settings locally for 1 hour (reduces API calls)
- Falls back to cached settings if API fails
- Falls back to default settings if no cache available

### 2. Settings Model (`admin_settings.dart`)

The `AdminSettings` model stores:
- `interstitialAdEnabled` - Whether to show interstitial ads
- `rewardAdEnabled` - Whether to show reward ads
- `youtubeLink` - YouTube video ID
- `redeemWebsiteLink` - Website URL for "ಉಚಿತ ಕನ್ನಡ ಕ್ಯಾಲೆಂಡರ್ ಪಡೆಯಿರಿ" button
- `visitWebsiteLink` - Website URL for "ವೆಬ್‌ಸೈಟ್‌ಗೆ ಭೇಟಿ ನೀಡಿ" button
- `lastUpdated` - Timestamp of last update

### 3. Seven Day Challenge Screen Integration

The `seven_day_challenge_screen.dart` has been updated to:

#### Fetch Settings on Load
```dart
Future<void> _loadAdminSettings() async {
  final settings = await AdminPanelService.instance.fetchSettings();
  // Updates YouTube video ID and website URL
  // Only preloads ads if enabled
}
```

#### Use YouTube Link from Admin Panel
- Fetches YouTube video ID from admin panel
- Initializes YouTube player with the fetched video ID
- Falls back to default if API fails

#### Use Website Links from Admin Panel
- Uses `redeemWebsiteLink` when user clicks "ಉಚಿತ ಕನ್ನಡ ಕ್ಯಾಲೆಂಡರ್ ಪಡೆಯಿರಿ" button
- Uses `visitWebsiteLink` when user clicks "ವೆಬ್‌ಸೈಟ್‌ಗೆ ಭೇಟಿ ನೀಡಿ" button
- Falls back to defaults if API fails

#### Control Interstitial Ads
```dart
final shouldShowAd = _adminSettings?.interstitialAdEnabled ?? true;
if (shouldShowAd) {
  InterstitialAdManager.instance.showAd(...);
} else {
  // Skip ad, show celebration directly
}
```

#### Control Reward Ads
```dart
final shouldShowRewardAd = _adminSettings?.rewardAdEnabled ?? true;
if (shouldShowRewardAd) {
  RewardedAdManager.instance.showAd(...);
} else {
  // Skip ad, perform action directly
}
```

## API Response Format

The admin panel API returns JSON in this format:

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

## Caching Strategy

1. **First Request**: Fetches from API and caches locally
2. **Subsequent Requests**: Uses cache if less than 1 hour old
3. **API Failure**: Falls back to cached settings (even if expired)
4. **No Cache**: Uses default settings

## Default Settings

If the API is unavailable, the app uses these defaults:
- Interstitial Ads: **Enabled**
- Reward Ads: **Enabled**
- YouTube Link: `gsIkR1Jiltw`
- Redeem Website Link: `https://kannadacalendar.in/`
- Visit Website Link: `https://kannadacalendar.in/`

## Testing

### Test Admin Panel Changes

1. Log in to admin panel
2. Change settings (toggle ads, update links)
3. Save settings
4. In Flutter app:
   - Close and reopen the app (or wait 1 hour for cache to expire)
   - Settings will be fetched from API

### Test Offline Behavior

1. Turn off internet connection
2. Open the app
3. App will use cached settings or defaults

## Files Modified

1. **`lib/models/admin_settings.dart`** - New model for settings
2. **`lib/services/admin_panel_service.dart`** - New service to fetch settings
3. **`lib/screens/seven_day_challenge_screen.dart`** - Updated to use admin panel settings

## Benefits

✅ **Remote Control**: Change app behavior without app update
✅ **A/B Testing**: Easily toggle ads on/off
✅ **Content Management**: Update YouTube videos and links instantly
✅ **Offline Support**: Works with cached settings when offline
✅ **Performance**: Caching reduces API calls

## Troubleshooting

### Settings Not Updating
- Check if cache has expired (1 hour)
- Force refresh by clearing app data or waiting
- Verify API endpoint is accessible

### Ads Not Showing/Showing When Disabled
- Check admin panel settings
- Verify `interstitialAdEnabled` and `rewardAdEnabled` values
- Check app logs for API fetch errors

### Wrong YouTube Video
- Verify YouTube link in admin panel
- Check if video ID is correct (11 characters)
- Ensure API is returning correct value

