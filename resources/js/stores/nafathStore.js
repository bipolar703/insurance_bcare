import create from 'zustand'
import mitt from 'mitt'

const emitter = mitt()

const useNafathStore = create((set) => ({
  code: null,
  isLoading: false,
  error: null,

  setCode: (code) => set({ code, isLoading: false }),
  setLoading: (isLoading) => set({ isLoading }),
  setError: (error) => set({ error, isLoading: false }),
}))

export { useNafathStore, emitter }
