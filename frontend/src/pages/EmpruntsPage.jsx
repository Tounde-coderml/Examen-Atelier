import { useEffect, useState } from 'react'
import api from '../api'

export default function EmpruntsPage() {
  const [emprunts, setEmprunts] = useState([])
  const [materials, setMaterials] = useState([])
  const [form, setForm] = useState({ material_id: '', Date_prevue_de_retour: '' })

  const loadData = async () => {
    try {
      const [empruntsResponse, materialsResponse] = await Promise.all([
        api.get('/emprunts'),
        api.get('/materiels'),
      ])

      setEmprunts(empruntsResponse.data.data || [])
      setMaterials(materialsResponse.data.data || [])
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
      await api.post('/emprunts', form)
      setForm({ material_id: '', Date_prevue_de_retour: '' })
      loadData()
    } catch (error) {
      console.error(error)
    }
  }

  const handleReturn = async (id) => {
    try {
      await api.patch(`/emprunts/${id}/retour`)
      loadData()
    } catch (error) {
      console.error(error)
    }
  }

  return (
    <div>
      <h2>Emprunts</h2>

      <form onSubmit={handleSubmit} className="stack-form small-form">
        <select
          value={form.material_id}
          onChange={(e) => setForm({ ...form, material_id: e.target.value })}
          required
        >
          <option value="">Choisir un matériel</option>
          {materials.map((material) => (
            <option key={material.id} value={material.id}>
              {material.nom}
            </option>
          ))}
        </select>

        <input
          type="date"
          value={form.Date_prevue_de_retour}
          onChange={(e) => setForm({ ...form, Date_prevue_de_retour: e.target.value })}
          required
        />

        <button type="submit">Créer un emprunt</button>
      </form>

      <table className="data-table">
        <thead>
          <tr>
            <th>Matériel</th>
            <th>Du</th>
            <th>Retour prévu</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          {emprunts.map((emprunt) => (
            <tr key={emprunt.id}>
              <td>{emprunt.material_id}</td>
              <td>{emprunt.Date_emprunt}</td>
              <td>{emprunt.Date_prevue_de_retour}</td>
              <td>{emprunt.status}</td>
              <td>
                {emprunt.status !== 'Retourné' && (
                  <button type="button" onClick={() => handleReturn(emprunt.id)}>
                    Retourner
                  </button>
                )}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  )
}
