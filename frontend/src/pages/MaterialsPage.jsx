import { useEffect, useState } from 'react'
import api from '../api'

export default function MaterialsPage() {
  const [materials, setMaterials] = useState([])
  const [categories, setCategories] = useState([])
  const [form, setForm] = useState({
    category_id: '',
    nom: '',
    description: '',
    numero_de_serie: '',
    quantite_disponible: 1,
    etats: 'Disponible',
  })

  const loadData = async () => {
    try {
      const [materialsResponse, categoriesResponse] = await Promise.all([
        api.get('/materiels'),
        api.get('/categories'),
      ])

      setMaterials(materialsResponse.data.data || [])
      setCategories(categoriesResponse.data.data || [])
    } catch (error) {
      console.error(error)
    }
  }

  useEffect(() => {
    loadData()
  }, [])

  const handleSubmit = async (event) => {
    event.preventDefault()

    try {
      await api.post('/materiels', {
        ...form,
        numero_de_serie: Number(form.numero_de_serie),
        quantite_disponible: Number(form.quantite_disponible),
      })
      setForm({
        category_id: '',
        nom: '',
        description: '',
        numero_de_serie: '',
        quantite_disponible: 1,
        etats: 'Disponible',
      })
      loadData()
    } catch (error) {
      console.error(error)
    }
  }

  return (
    <div>
      <h2>Matériels</h2>

      <form onSubmit={handleSubmit} className="stack-form small-form">
        <select
          value={form.category_id}
          onChange={(e) => setForm({ ...form, category_id: e.target.value })}
          required
        >
          <option value="">Choisir une catégorie</option>
          {categories.map((category) => (
            <option key={category.id} value={category.id}>
              {category.nom}
            </option>
          ))}
        </select>

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

        <input
          type="number"
          placeholder="Numéro de série"
          value={form.numero_de_serie}
          onChange={(e) => setForm({ ...form, numero_de_serie: e.target.value })}
          required
        />

        <input
          type="number"
          placeholder="Quantité disponible"
          min="0"
          value={form.quantite_disponible}
          onChange={(e) => setForm({ ...form, quantite_disponible: e.target.value })}
          required
        />

        <select
          value={form.etats}
          onChange={(e) => setForm({ ...form, etats: e.target.value })}
        >
          <option value="Disponible">Disponible</option>
          <option value="En maintenance">En maintenance</option>
          <option value="Hors service">Hors service</option>
        </select>

        <button type="submit">Ajouter</button>
      </form>

      <table className="data-table">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Stock</th>
            <th>État</th>
          </tr>
        </thead>
        <tbody>
          {materials.map((material) => (
            <tr key={material.id}>
              <td>{material.nom}</td>
              <td>{material.category_id}</td>
              <td>{material.quantite_disponible}</td>
              <td>{material.etats}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  )
}
