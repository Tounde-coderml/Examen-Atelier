#!/bin/sh
set -e

echo "Démarrage du backend Laravel..."

if [ ! -f /app/.env ]; then
  cp /app/.env.docker /app/.env
  echo ".env.docker copié vers .env"
fi


php artisan key:generate --force


echo "En attente de MySQL..."
until nc -z mysql 3306 2>/dev/null; do
  echo "MySQL indisponible - nouvelle tentative dans 1s"
  sleep 1
done

echo "MySQL est prêt"

echo "Exécution des migrations..."
php artisan migrate:fresh --seed --force

echo "Backend prêt !"
php artisan serve --host=0.0.0.0 --port=8000