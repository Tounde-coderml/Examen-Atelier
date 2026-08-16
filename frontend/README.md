# Frontend - Examen Atelier

Application React pour la gestion des prêts de matériel.

## 🚀 Développement

```bash
# Installer les dépendances
npm install

# Démarrer le serveur de développement
npm run dev

# L'application sera disponible à http://localhost:5173
```

## 🏗️ Build

```bash
# Compiler pour la production
npm run build

# Prévisualiser la build
npm run preview
```

## 🧹 Linting

```bash
npm run lint
```

## 📦 Dépendances principales

- **React 19** : Framework UI
- **React Router v7** : Routage
- **Axios** : Client HTTP
- **Vite** : Build tool et dev server

## 🔌 Variables d'environnement

Créez un fichier `.env.local` :

```env
VITE_API_URL=http://localhost:8000/api
```

En développement, cette valeur par défaut est déjà configurée.

## 📁 Structure du projet

```
src/
├── pages/          # Composants de page
│   ├── LoginPage.jsx
│   ├── DashboardPage.jsx
│   ├── CategoriesPage.jsx
│   ├── MaterialsPage.jsx
│   ├── EmpruntsPage.jsx
│   ├── ProfilePage.jsx
│   └── UsersPage.jsx
├── components/     # Composants réutilisables
│   └── ProtectedRoute.jsx
├── context/        # Context API
│   └── AuthContext.jsx
├── api.js          # Configuration Axios
├── App.jsx         # Routage principal
├── App.css         # Styles globaux
└── main.jsx        # Point d'entrée
```

## 🔐 Authentification

Le token est stocké dans `localStorage` et injecté automatiquement dans les requêtes API via le client Axios.

L'application détecte automatiquement l'état de connexion et redirige vers la page de login si nécessaire.

## 🌐 Communication API

Toutes les requêtes sont centralisées dans `api.js` avec gestion automatique du Bearer token.

Exemples :

```javascript
// GET
const { data } = await api.get('/categories')

// POST
await api.post('/materiels', { nom: 'Laptop', ... })

// PATCH
await api.patch(`/users/${id}`, { status: 'Active' })

// DELETE
await api.delete(`/emprunts/${id}`)
```

## 📱 Responsive

L'application est entièrement responsive et fonctionne sur desktop et mobile.

## 🚢 Déploiement Docker

Voir le fichier `Dockerfile.frontend` pour la configuration Docker.
