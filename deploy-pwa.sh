#!/bin/bash

# DHI PWA Deploy Script
echo "🚀 Starting DHI PWA Deployment..."

# Pull latest changes
echo "📥 Pulling latest changes..."
git pull origin master

# Clear all caches
echo "🧹 Clearing Laravel caches..."
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/

echo "✅ Deployment completed!"
echo ""
echo "🔗 Test URLs:"
echo "Main site: https://dhiegypt.com/ar/"
echo "Manifest: https://dhiegypt.com/manifest.json"
echo "PWA Test: https://dhiegypt.com/pwa-test.html"
echo ""
echo "📱 Next steps:"
echo "1. Test manifest.json accessibility"
echo "2. Check Apple meta tags in page source"
echo "3. Test PWA on iPhone Safari"