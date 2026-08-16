# 📦 Examen Atelier - Gestion des Prêts de Matériel

Application de gestion des prêts de matériel informatique pour une entreprise, développée selon l'architecture **Backend Laravel API + Frontend React**.

## 👥 Membres du groupe

- DOSSOU-YOVO Leriche
- MITCHODJEHOUN Noé
- CDJOVI Ostie

## 🏗 Architecture choisie

**Option Full Stack** : Backend Laravel (API REST) + Frontend React consommant exclusivement l'API.

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
- **Laravel 13** : Framework PHP
- **PHP 8.4**
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

## ⚙️ Configuration

Le backend utilise le fichier `.env.docker`, copié automatiquement en `.env` au démarrage du conteneur. Les variables principales :

| Variable | Description | Valeur par défaut |
|---|---|---|
| `DB_HOST` | Hôte MySQL (nom du service Docker) | `mysql` |
| `DB_DATABASE` | Nom de la base de données | `Examen_atelier` |
| `DB_USERNAME` | Utilisateur MySQL | `atelier` |
| `DB_PASSWORD` | Mot de passe MySQL | `password` |
| `APP_URL` | URL du backend | `http://localhost:8000` |

Le frontend utilise `VITE_API_URL` pour connaître l'adresse de l'API (définie dans `compose.yaml`).

## 🚀 Lancer l'application avec Docker (méthode recommandée)

Aucune installation locale de PHP, Composer ou Node n'est nécessaire — tout est géré par Docker à partir des images publiées.

```bash
# Cloner le projet
git clone https://github.com/Tounde-coderml/Examen-Atelier.git
cd Examen-Atelier

# Lancer l'application (télécharge les images publiées, aucun build requis)
docker compose up
```

L'application sera disponible à :
- **Frontend** : http://localhost:5173
- **Backend API** : http://localhost:8000/api

Les migrations et les seeds s'exécutent **automatiquement** au démarrage du conteneur backend — aucune commande manuelle n'est nécessaire.

## 🧑‍💻 Installation manuelle (sans Docker)

### Backend

```bash
composer install
cp .env.example .env
php artisan key:generate
# Configurer les variables DB_* dans .env pour pointer vers votre instance MySQL locale
php artisan migrate:fresh --seed
php artisan serve
```

### Frontend

```bash
cd frontend
npm install
npm run dev
```

## 🔐 Identifiants de test

- **Admin**
  - Email : `admin@atelier.test`
  - Mot de passe : `password`
- **Employés** : 10 utilisateurs générés automatiquement, mot de passe `password`

## 🧪 Tests

```bash
# Avec Docker
docker compose exec backend php artisan test

# Sans Docker
php artisan test
```

## 📝 Scripts utilitaires

```bash
# Pusher vers GitHub (vérifie le message de commit, add, commit, push)
./scripts/push.sh "Message du commit"
```

## 📦 Déploiement Docker Hub

Les images de production sont publiées sur Docker Hub :
- [`lerichebsb/atelier-backend:latest`](https://hub.docker.com/r/lerichebsb/atelier-backend)
- [`lerichebsb/atelier-frontend:latest`](https://hub.docker.com/r/lerichebsb/atelier-frontend)

Le fichier `compose.yaml` (à la racine du projet) utilise directement ces images publiées — `docker compose up` seul suffit, sans aucun build local.

## 🔄 CI/CD avec GitHub Actions

Le workflow (`.github/workflows/tests.yml`) automatise à chaque `push` et `pull request` :
- Installation des dépendances (Composer + npm)
- Préparation de Laravel (clé d'application, migrations)
- Exécution des tests PHPUnit
- Lint et build du frontend

## 📸 Captures d'écran

les captures d'ecran sont dans le dossier capture d'ecran 