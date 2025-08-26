# HTTPS Configuration Guide

## Overview

Aplikasi JASTIPUSA Web Admin telah dikonfigurasi untuk mendukung full HTTPS. Berikut adalah panduan untuk mengaktifkan dan mengkonfigurasi HTTPS.

## Configuration Files Modified

### 1. AppServiceProvider.php

-   Menambahkan URL::forceScheme('https') untuk production
-   Mendeteksi proxy headers untuk hosting environments
-   Mendukung konfigurasi APP_FORCE_HTTPS

### 2. config/app.php

-   Menambahkan setting `force_https` yang dapat dikonfigurasi via environment

### 3. ForceHttps Middleware

-   Middleware yang memaksa redirect HTTP ke HTTPS
-   Aktif di production atau ketika APP_FORCE_HTTPS=true

### 4. SecurityHeaders Middleware

-   Menambahkan security headers untuk HTTPS:
    -   Strict-Transport-Security
    -   Content-Security-Policy
    -   X-Frame-Options
    -   X-Content-Type-Options
    -   X-XSS-Protection
    -   Referrer-Policy
    -   Permissions-Policy

## Environment Variables

### For Production (.env)

```bash
APP_ENV=production
APP_URL=https://yourdomain.com
APP_FORCE_HTTPS=true
```

### For Development (.env)

```bash
APP_ENV=local
APP_URL=http://localhost
APP_FORCE_HTTPS=false
```

## Deployment Steps

### 1. Update Environment Variables

```bash
# Production settings
APP_ENV=production
APP_URL=https://your-production-domain.com
APP_FORCE_HTTPS=true
```

### 2. Clear Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 3. Verify SSL Certificate

Pastikan SSL certificate sudah terinstall di server dan valid.

### 4. Test HTTPS

-   Akses aplikasi melalui HTTPS
-   Verify tidak ada mixed content warnings
-   Test redirect dari HTTP ke HTTPS

## Hosting Environment Support

### Proxy Detection

AppServiceProvider secara otomatis mendeteksi proxy headers:

-   HTTP_X_FORWARDED_PROTO
-   HTTP_X_FORWARDED_SSL
-   SERVER_PORT (443)

### Common Hosting Platforms

-   **Shared Hosting**: Biasanya sudah handle HTTPS forwarding
-   **VPS/Dedicated**: Perlu setup SSL certificate manual
-   **Cloud Platforms**: Configure load balancer untuk HTTPS

## Security Features

### CORS Headers

CORS middleware sudah dikonfigurasi untuk mendukung HTTPS requests.

### CSRF Protection

CSRF tokens tetap aktif dan kompatibel dengan HTTPS.

### Secure Cookies

Session cookies otomatis secure di HTTPS environment.

## Troubleshooting

### Mixed Content Issues

Jika ada warning mixed content:

1. Periksa asset URLs menggunakan HTTPS
2. Update CDN links ke HTTPS
3. Verify external API calls menggunakan HTTPS

### Redirect Loops

Jika terjadi redirect loop:

1. Periksa proxy configuration
2. Disable APP_FORCE_HTTPS temporarily
3. Check server configuration

### Performance Impact

-   Security headers minimal impact
-   HTTPS redirect hanya terjadi sekali per session
-   Browser akan cache HSTS settings

## Monitoring

### Headers Verification

Use online tools untuk verify security headers:

-   https://securityheaders.com/
-   https://observatory.mozilla.org/

### SSL Certificate Monitoring

Setup monitoring untuk SSL certificate expiration.

## Development Notes

### Local Development

-   HTTPS tidak dipaksa di environment local
-   Gunakan APP_FORCE_HTTPS=false untuk development
-   Test HTTPS dengan tools seperti ngrok

### Testing

-   Unit tests tidak affected oleh HTTPS configuration
-   Feature tests perlu setup HTTPS context jika diperlukan

## Production Checklist

-   [ ] SSL Certificate installed dan valid
-   [ ] APP_ENV=production
-   [ ] APP_URL menggunakan https://
-   [ ] APP_FORCE_HTTPS=true
-   [ ] Cache cleared setelah configuration change
-   [ ] Test redirect HTTP → HTTPS
-   [ ] Verify security headers active
-   [ ] No mixed content warnings
-   [ ] All external resources menggunakan HTTPS
