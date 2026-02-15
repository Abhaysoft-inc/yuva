#!/bin/bash

# ============================================
# Hostinger Deployment Script
# Domain: dashboard.yuvamaitree.org.in
# ============================================

# Configuration
REMOTE_USER="u236674186"
REMOTE_HOST="89.117.157.133"
REMOTE_PORT="65002"
REMOTE_PATH="/home/u236674186/domains/dashboard.yuvamaitree.org.in"
REMOTE="${REMOTE_USER}@${REMOTE_HOST}"

echo "🚀 Starting deployment to Hostinger..."

# Step 1: Build assets locally
echo "📦 Building frontend assets..."
npm run build

# Step 2: Sync app files (excluding public, node_modules, .git, .env)
echo "📤 Uploading application files..."
rsync -avz --delete -e "ssh -p ${REMOTE_PORT}" \
    --exclude='public' \
    --exclude='node_modules' \
    --exclude='.git' \
    --exclude='.env' \
    --exclude='storage/logs/*' \
    --exclude='storage/framework/cache/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/views/*' \
    --exclude='tests' \
    ./ ${REMOTE}:${REMOTE_PATH}/

# Step 3: Sync public folder contents to public_html
echo "📤 Uploading public files..."
rsync -avz --delete -e "ssh -p ${REMOTE_PORT}" \
    --exclude='.htaccess' \
    public/ ${REMOTE}:${REMOTE_PATH}/public_html/

# Step 4: Run remote commands
echo "⚙️  Running server-side commands..."
ssh -p ${REMOTE_PORT} ${REMOTE} << 'ENDSSH'
    cd /home/u236674186/domains/dashboard.yuvamaitree.org.in

    # Install/update composer dependencies
    php8.2 /usr/bin/composer install --no-dev --optimize-autoloader 2>&1 || \
    composer install --no-dev --optimize-autoloader

    # Run migrations
    php artisan migrate --force

    # Clear and rebuild caches
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    # Ensure storage link
    php artisan storage:link 2>/dev/null

    # Set permissions
    chmod -R 755 storage bootstrap/cache
    chmod -R 775 storage/logs storage/framework

    echo "✅ Server-side setup complete!"
ENDSSH

echo "🎉 Deployment completed successfully!"
echo "🌐 Visit: https://dashboard.yuvamaitree.org.in"
