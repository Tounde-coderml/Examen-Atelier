#!/bin/sh
set -e

echo "Starting Laravel backend..."

# Copier .env.docker comme .env s'il n'existe pas
if [ ! -f /app/.env ]; then
  cp /app/.env.docker /app/.env
  echo "Copied .env.docker to .env"
fi

# Attendre que MySQL soit prêt
echo "Waiting for MySQL to be ready..."
until nc -z mysql 3306 2>/dev/null; do
  echo "MySQL is unavailable - sleeping"
  sleep 1
done

echo "MySQL is up and running"

# Exécuter les migrations
echo "Running migrations..."
php artisan migrate:fresh --seed --force

echo "Backend is ready!"

# Démarrer le serveur Laravel
php artisan serve --host=0.0.0.0 --port=8000
