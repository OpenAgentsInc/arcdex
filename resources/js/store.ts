import { Connect } from '@nostr-connect/connect'
import axios from 'axios'
import { create } from 'zustand'

interface Store {
  pubkey: string
  connect: Connect | null
  logout: (setPubkey: any) => void
  setPubkey: (pubkey: string) => void
  setConnect: (connect: Connect) => void
}

export const useStore = create<Store>((set) => ({
  pubkey: '',
  setPubkey: (pubkey: string) => set({ pubkey }),
  connect: null,
  setConnect: (connect: Connect) => set({ connect }),
  logout: async (setPubkey) => {
    console.log('logout placeholder - do we have connect object?')
    const { connect } = useStore.getState()
    console.log('connect: ', connect)

    if (!connect) {
      console.log('no connect object, returning')
      return
    }

    setPubkey('')
    console.log('disconnecting?')
    await connect.disconnect()
    console.log('disconnected...')

    await axios.post(
      '/logout',
      {},
      {
        headers: {
          'Content-Type': 'application/json',
        },
      }
    )
    window.location.replace('/login')
  },
}))
