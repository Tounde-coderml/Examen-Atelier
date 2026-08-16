import { useEffect, useState } from 'react'
import api from '../api'

export default function DashboardPage() {
  const [stats, setStats] = useState(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    const load = async () => {
      try {
        const { data } = await api.get('/dashboard')
        setStats(data.data)
      } catch (error) {
        console.error(error)
      } finally {
        setLoading(false)
      }
    }

    load()
  }, [])

  if (loading) {
    return <div className="loading">Chargement du tableau de bord...</div>
  }

  const cards = [
    { label: 'Utilisateurs', value: stats?.utilisateurs || 0 },
    { label: 'Catégories', value: stats?.categories || 0 },
    { label: 'Matériels', value: stats?.materiels || 0 },
    { label: 'Disponibles', value: stats?.materiels_disponibles || 0 },
    { label: 'En maintenance', value: stats?.materiels_en_maintenance || 0 },
    { label: 'Hors service', value: stats?.materiels_hors_service || 0 },
    { label: 'Emprunts en cours', value: stats?.emprunts_en_cours || 0 },
    { label: 'Retournés', value: stats?.emprunts_retournes || 0 },
  ]

  return (
    <div>
      <h2>Tableau de bord</h2>
      <div className="stats-grid">
        {cards.map((card) => (
          <div className="stat-card" key={card.label}>
            <span>{card.label}</span>
            <strong>{card.value}</strong>
          </div>
        ))}
      </div>
    </div>
  )
}
