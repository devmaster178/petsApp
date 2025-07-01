#!/bin/bash

set -e

echo "⏳ Installing PHP dependencies..."
composer install

echo "⏳ Installing JS dependencies..."
npm install

echo "🔧 Building Tailwind CSS..."
npm run build

echo "📦 Creating database..."
php bin/console doctrine:database:create --if-not-exists

echo "🛠️ Waiting for DB..."
until php bin/console doctrine:query:sql "SELECT 1" > /dev/null 2>&1; do
  sleep 2
done

echo "📜 Running migrations..."
php bin/console doctrine:migrations:migrate --no-interaction

echo "🚀 Starting PHP-FPM..."
exec php-fpm
