import { Connect } from '@nostr-connect/connect'
import { create } from 'zustand'

interface Store {
  pubkey: string
  connect: Connect | null
  setPubkey: (pubkey: string) => void
  setConnect: (connect: Connect) => void
}

export const useStore = create<Store>((set) => ({
  pubkey: '',
  setPubkey: (pubkey: string) => set({ pubkey }),
  connect: null,
  setConnect: (connect: Connect) => set({ connect }),
}))
