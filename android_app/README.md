# Sahashra Janith Portfolio - Native Android Companion Application

This Android Application links directly to Sahashra Janith's Portfolio website & Admin panel with a native WebView, Splash Screen, Pull-To-Refresh, and intent handlers for WhatsApp and Email.

---

## 📱 Features
- **Custom Splash Screen**: Featuring Sahashra Janith (`SJ`) branding.
- **High-Performance WebView**: Configured with DOM Storage, Hardware Acceleration, and smooth 60fps rendering.
- **Swipe-to-Refresh**: Easily reload content with a simple pull down gesture.
- **Smart Intent Handler**: Automatically opens native Android apps for WhatsApp (`wa.me`), Email (`mailto:`), and Phone calls (`tel:`).
- **Offline Mode Fallback**: Displays an offline retry screen if connection fails.

---

## 🛠️ How to Build & Run in Android Studio

1. **Open Android Studio**.
2. Click **Open an existing Android Studio project**.
3. Select this folder: `c:\xampp\htdocs\janithme\android_app`.
4. Wait for Gradle Sync to complete.
5. In `MainActivity.java`, update `TARGET_URL` if you wish to link to local XAMPP (`http://10.0.2.2/janithme/`) or live domain (`https://sahashrajanith.site/`).
6. Click **Run App** (or press `Shift + F10`) to launch on an Emulator or connected Android phone.
7. To generate a standalone APK:
   - Go to **Build > Build Bundle(s) / APK(s) > Build APK(s)**.

---

## 📦 Output Location
The compiled `.apk` file will be generated at:
`android_app/app/build/outputs/apk/release/app-release.apk`
