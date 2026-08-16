#!/bin/bash

# Script de déploiement Docker - Examen Atelier

set -e

echo "🚀 Déploiement de l'application Examen Atelier..."

# Vérifier Docker
if ! command -v docker &> /dev/null; then
    echo "❌ Docker n'est pas installé"
    exit 1
fi

# Vérifier docker-compose
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose n'est pas installé"
    exit 1
fi

# Construire les images
echo "📦 Construction des images Docker..."
docker-compose build

# Démarrer les services
echo "🎬 Démarrage des services..."
docker-compose up -d

# Attendre que le backend soit prêt
echo "⏳ Attente de la disponibilité du backend..."
sleep 10

echo "✅ Application prête!"
echo ""
echo "Accès à l'application:"
echo "  - Frontend: http://localhost:5173"
echo "  - Backend API: http://localhost:8000/api"
echo ""
echo "Identifiants de test:"
echo "  - Email: admin@atelier.test"
echo "  - Mot de passe: password"
echo ""
echo "Commandes utiles:"
echo "  - Arrêter: docker-compose down"
echo "  - Logs: docker-compose logs -f"
echo "  - Accès au backend: docker-compose exec backend bash"
