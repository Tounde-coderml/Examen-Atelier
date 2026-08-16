import { useState } from 'react'
import api from '../api'
import { useAuth } from '../context/AuthContext'

export default function ProfilePage() {
  const { user, setUser } = useAuth()
  const [form, setForm] = useState({
    name: user?.name || '',
    email: user?.email || '',
    password: '',
    password_confirmation: '',
  })
  const [loading, setLoading] = useState(false)
  const [message, setMessage] = useState('')
  const [error, setError] = useState('')

  const handleSubmit = async (event) => {
    event.preventDefault()
    setLoading(true)
    setMessage('')
    setError('')

    try {
      const payload = {
        name: form.name,
        email: form.email,
      }

      // Inclure password seulement s'il est rempli
      if (form.password) {
        payload.password = form.password
        payload.password_confirmation = form.password_confirmation
      }

      const { data } = await api.patch(`/users/${user.id}`, payload)
      setUser(data.data)
      setMessage('Profil mis à jour avec succès')

      // Réinitialiser les champs de mot de passe
      setForm({
        name: data.data.name,
        email: data.data.email,
        password: '',
        password_confirmation: '',
      })
    } catch (err) {
      const errors = err.response?.data?.errors || {}
      const errorList = Object.values(errors)
        .flat()
        .join(', ')
      setError(errorList || 'Erreur lors de la mise à jour')
    } finally {
      setLoading(false)
    }
  }

  return (
    <div>
      <h2>Mon profil</h2>

      <div className="profile-container">
        <div className="profile-info">
          <div className="info-row">
            <span className="info-label">Rôle</span>
            <span className="info-value">{user?.role}</span>
          </div>
          <div className="info-row">
            <span className="info-label">Statut</span>
            <span className="info-value">{user?.status}</span>
          </div>
          <div className="info-row">
            <span className="info-label">Membre depuis</span>
            <span className="info-value">
              {new Date(user?.created_at).toLocaleDateString('fr-FR')}
            </span>
          </div>
        </div>

        <form onSubmit={handleSubmit} className="profile-form">
          <h3>Modifier vos informations</h3>

          <div className="form-group">
            <label>
              Nom complet
              <input
                type="text"
                value={form.name}
                onChange={(e) => setForm({ ...form, name: e.target.value })}
                required
              />
            </label>
          </div>

          <div className="form-group">
            <label>
              Email
              <input
                type="email"
                value={form.email}
                onChange={(e) => setForm({ ...form, email: e.target.value })}
                required
              />
            </label>
          </div>

          <div className="separator">Changer le mot de passe (facultatif)</div>

          <div className="form-group">
            <label>
              Nouveau mot de passe
              <input
                type="password"
                value={form.password}
                onChange={(e) => setForm({ ...form, password: e.target.value })}
                placeholder="Laissez vide pour ne pas changer"
              />
            </label>
          </div>

          <div className="form-group">
            <label>
              Confirmer le mot de passe
              <input
                type="password"
                value={form.password_confirmation}
                onChange={(e) =>
                  setForm({ ...form, password_confirmation: e.target.value })
                }
                placeholder="Confirmation"
              />
            </label>
          </div>

          {message && <div className="success-message">{message}</div>}
          {error && <div className="error-box">{error}</div>}

          <button type="submit" disabled={loading} className="submit-button">
            {loading ? 'Mise à jour en cours...' : 'Enregistrer les modifications'}
          </button>
        </form>
      </div>
    </div>
  )
}
