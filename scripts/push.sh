#!/bin/bash

# Script de push vers GitHub - Examen Atelier

set -e

# Vérifier que le message de commit est fourni
if [ -z "$1" ]; then
    echo "❌ Erreur: Message de commit requis"
    echo "Usage: ./scripts/push.sh 'Message de commit'"
    exit 1
fi

COMMIT_MESSAGE="$1"

echo "📝 Message de commit: $COMMIT_MESSAGE"

# Ajouter les modifications
echo "📦 Ajout des modifications..."
git add -A

# Créer le commit
echo "💾 Création du commit..."
git commit -m "$COMMIT_MESSAGE"

# Envoyer vers GitHub
echo "🚀 Envoi vers GitHub..."
git push origin main

echo "✅ Push réussi!"
