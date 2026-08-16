# 📦 Examen Atelier - Gestion des Prêts de Matériel

Application de gestion des prêts de matériel informatique pour une entreprise, développée selon l'architecture **Backend Laravel API + Frontend React**.

## 🎯 Fonctionnalités principales

- ✅ **Authentification** : Connexion, déconnexion, profil utilisateur avec Sanctum
- ✅ **Gestion des utilisateurs** : Création, édition, activation/désactivation (admin)
- ✅ **Gestion des catégories** : CRUD complet des catégories de matériel
- ✅ **Gestion des matériels** : CRUD, recherche, filtrage par catégorie, pagination
- ✅ **Gestion des emprunts** : Création d'emprunt, retour de matériel avec gestion du stock
- ✅ **Tableau de bord** : Statistiques en temps réel
- ✅ **Règles métier** : Vérification du stock, état des matériels, etc.

## 🛠 Technologies utilisées

### Backend
- **Laravel 11** : Framework PHP
- **MySQL 8.0** : Base de données
- **Laravel Sanctum** : Authentification API
- **Eloquent ORM** : Gestion des relations
- **PHPUnit** : Tests automatisés

### Frontend
- **React 19** : Framework JavaScript
- **React Router v7** : Routage
- **Vite** : Bundler et dev server
- **Axios** : Client HTTP

### DevOps
- **Docker** : Containerisation
- **Docker Compose** : Orchestration
- **GitHub Actions** : CI/CD

## 🚀 Lancer l'application avec Docker

```bash
# Cloner le projet
git clone [lien-du-repo]
cd Examen-Atelier

# Lancer avec Docker (automatise tout)
docker-compose up --build

# L'application sera disponible à:
# Frontend: http://localhost:5173
# Backend API: http://localhost:8000/api
```

Les migrations et seeds s'exécutent automatiquement au démarrage !

## 🔐 Identifiants de test

- **Admin**
  - Email: `admin@atelier.test`
  - Mot de passe: `password`

- **Employés** : 10 utilisateurs avec mot de passe `password`

## 🧪 Tests

```bash
# Avec Docker
docker-compose exec backend php artisan test

# Sans Docker
php artisan test
```

## 📝 Scripts utilitaires

```bash
# Déployer avec Docker
./scripts/docker-deploy.sh

# Pusher vers GitHub
./scripts/push.sh "Message du commit"
```

## 📦 Déploiement Docker Hub

Les images sont disponibles à :
- `[utilisateur]/examen-atelier-backend:latest`
- `[utilisateur]/examen-atelier-frontend:latest`

## 🔄 CI/CD avec GitHub Actions

Le workflow automatise :
- Installation des dépendances
- Migrations de base de données
- Tests PHPUnit
- Lint et build frontend

Déclenché sur chaque push et pull request.

## 📖 Documentation complète

Voir le fichier README.md pour la documentation complète incluant :
- Architecture détaillée
- Configuration
- Documentation API
- Troubleshooting
- Et plus...
