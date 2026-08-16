import './App.css'
import { BrowserRouter, Link, Navigate, Outlet, Route, Routes } from 'react-router-dom'
import ProtectedRoute from './components/ProtectedRoute'
import { AuthProvider, useAuth } from './context/AuthContext'
import CategoriesPage from './pages/CategoriesPage'
import DashboardPage from './pages/DashboardPage'
import EmpruntsPage from './pages/EmpruntsPage'
import LoginPage from './pages/LoginPage'
import MaterialsPage from './pages/MaterialsPage'
import ProfilePage from './pages/ProfilePage'
import UsersPage from './pages/UsersPage'

function AppLayout() {
  const { user, logout } = useAuth()

  return (
    <div className="app-shell">
      <aside className="sidebar">
        <div>
          <h1>Atelier</h1>
          <p>Gestion de matériel</p>
        </div>

        <nav className="nav">
          <Link to="/">Dashboard</Link>
          <Link to="/categories">Catégories</Link>
          <Link to="/materiels">Matériels</Link>
          <Link to="/emprunts">Emprunts</Link>
          {user?.role === 'Administrateur' && <Link to="/utilisateurs">Utilisateurs</Link>}
          <Link to="/profil">Mon profil</Link>
        </nav>

        <div className="user-box">
          <span>{user?.name || user?.email || 'Utilisateur'}</span>
          <button type="button" onClick={logout} className="logout-button">
            Déconnexion
          </button>
        </div>
      </aside>

      <main className="content-panel">
        <Outlet />
      </main>
    </div>
  )
}

function AppRoutes() {
  const { user } = useAuth()

  return (
    <Routes>
      <Route
        path="/login"
        element={user ? <Navigate to="/" replace /> : <LoginPage />}
      />

      <Route element={<ProtectedRoute><AppLayout /></ProtectedRoute>}>
        <Route index element={<DashboardPage />} />
        <Route path="/categories" element={<CategoriesPage />} />
        <Route path="/materiels" element={<MaterialsPage />} />
        <Route path="/emprunts" element={<EmpruntsPage />} />
        <Route path="/profil" element={<ProfilePage />} />
        <Route path="/utilisateurs" element={user?.role === 'Administrateur' ? <UsersPage /> : <Navigate to="/" replace />} />
      </Route>

      <Route path="*" element={<Navigate to={user ? '/' : '/login'} replace />} />
    </Routes>
  )
}

function App() {
  return (
    <AuthProvider>
      <BrowserRouter>
        <AppRoutes />
      </BrowserRouter>
    </AuthProvider>
  )
}

export default App
