import { useEffect, useState } from 'react'
import api from '../api'

export default function CategoriesPage() {
  const [categories, setCategories] = useState([])
  const [loading, setLoading] = useState(true)
  const [form, setForm] = useState({ nom: '', description: '' })

  const loadCategories = async () => {
    try {
      const { data } = await api.get('/categories')
      setCategories(data.data || [])
    } catch (error) {
      console.error(error)
    } finally {
      setLoading(false)
    }
  }

  useEffect(() => {
    loadCategories()
  }, [])

  const handleSubmit = async (event) => {
    event.preventDefault()

    try {
      await api.post('/categories', form)
      setForm({ nom: '', description: '' })
      loadCategories()
    } catch (error) {
      console.error(error)
    }
  }

  if (loading) {
    return <div className="loading">Chargement des catégories...</div>
  }

  return (
    <div>
      <h2>Catégories</h2>

      <form onSubmit={handleSubmit} className="stack-form small-form">
        <input
          type="text"
          placeholder="Nom"
          value={form.nom}
          onChange={(e) => setForm({ ...form, nom: e.target.value })}
          required
        />
        <input
          type="text"
          placeholder="Description"
          value={form.description}
          onChange={(e) => setForm({ ...form, description: e.target.value })}
        />
        <button type="submit">Ajouter</button>
      </form>

      <table className="data-table">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          {categories.map((category) => (
            <tr key={category.id}>
              <td>{category.nom}</td>
              <td>{category.description}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  )
}
