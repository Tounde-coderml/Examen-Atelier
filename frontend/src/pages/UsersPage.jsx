import { useEffect, useState } from 'react'
import api from '../api'

export default function UsersPage() {
  const [users, setUsers] = useState([])
  const [loading, setLoading] = useState(true)

  const loadUsers = async () => {
    try {
      const { data } = await api.get('/users')
      setUsers(data.data || [])
    } catch (error) {
      console.error(error)
    } finally {
      setLoading(false)
    }
  }

  useEffect(() => {
    loadUsers()
  }, [])

  const handleStatusChange = async (userId, newStatus) => {
    try {
      await api.patch(`/users/${userId}`, { status: newStatus })
      loadUsers()
    } catch (error) {
      console.error(error)
    }
  }

  const handleDelete = async (userId) => {
    if (!window.confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
      return
    }

    try {
      await api.delete(`/users/${userId}`)
      loadUsers()
    } catch (error) {
      console.error(error)
    }
  }

  if (loading) {
    return <div className="loading">Chargement des utilisateurs...</div>
  }

  return (
    <div>
      <h2>Gestion des utilisateurs</h2>

      <table className="data-table">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {users.map((user) => (
            <tr key={user.id}>
              <td>{user.name}</td>
              <td>{user.email}</td>
              <td>{user.role}</td>
              <td>
                <select
                  value={user.status}
                  onChange={(e) => handleStatusChange(user.id, e.target.value)}
                >
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
              </td>
              <td>
                <button
                  type="button"
                  onClick={() => handleDelete(user.id)}
                  className="delete-button"
                >
                  Supprimer
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  )
}
