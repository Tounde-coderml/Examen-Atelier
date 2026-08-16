import { createContext, useContext, useEffect, useMemo, useState } from 'react'
import api from '../api'

const AuthContext = createContext(null)

export function AuthProvider({ children }) {
  const [user, setUser] = useState(() => JSON.parse(localStorage.getItem('atelier_user') || 'null'))
  const [token, setToken] = useState(() => localStorage.getItem('atelier_token') || '')
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    const restoreSession = async () => {
      if (!token) {
        setLoading(false)
        return
      }

      try {
        const { data } = await api.get('/user')
        setUser(data)
        localStorage.setItem('atelier_user', JSON.stringify(data))
      } catch {
        setToken('')
        setUser(null)
        localStorage.removeItem('atelier_token')
        localStorage.removeItem('atelier_user')
      } finally {
        setLoading(false)
      }
    }

    restoreSession()
  }, [token])

  const login = async (email, password) => {
    const { data } = await api.post('/login', { email, password })
    const userData = data.data

    localStorage.setItem('atelier_token', data.token)
    localStorage.setItem('atelier_user', JSON.stringify(userData))
    setToken(data.token)
    setUser(userData)

    return data
  }

  const logout = async () => {
    try {
      if (token) {
        await api.post('/logout')
      }
    } catch {
      // ignore logout API errors and clear local session anyway
    } finally {
      setUser(null)
      setToken('')
      localStorage.removeItem('atelier_token')
      localStorage.removeItem('atelier_user')
    }
  }

  const value = useMemo(
    () => ({ user, token, login, logout, loading, setUser }),
    [user, token, loading],
  )

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>
}

export function useAuth() {
  const context = useContext(AuthContext)

  if (!context) {
    throw new Error('useAuth must be used within AuthProvider')
  }

  return context
}
