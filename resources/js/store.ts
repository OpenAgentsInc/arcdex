import { Connect } from '@nostr-connect/connect'
import axios from 'axios'
import { create } from 'zustand'
import { secretKey } from './nostr/nostrConnect'

interface Store {
  pubkey: string
  connect: Connect | null
  logout: (setPubkey: any, setDelegation: any) => void
  setPubkey: (pubkey: string) => void
  setConnect: (connect: Connect) => void
}

export const useStore = create<Store>((set) => ({
  pubkey: '',
  setPubkey: (pubkey: string) => set({ pubkey }),
  connect: null,
  setConnect: (connect: Connect) => set({ connect }),
  logout: async (setPubkey, setDelegation) => {
    let { connect, pubkey } = useStore.getState()
    if (!connect) {
      //   console.log('no connect object, returning')
      connect = new Connect({
        secretKey,
        target: pubkey,
      })
      return
    }
    setPubkey('')
    setDelegation('')
    await connect.disconnect()
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
