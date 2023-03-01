import { useEffect } from 'react'
import { useStatePersist } from 'use-state-persist'
import { Connect } from '@nostr-connect/connect'
import { secretKey } from '../nostr/nostrConnect'
import { login } from '../auth'

export function useNostrConnect() {
  if (window.location.pathname === '/videos') return []
  const [pubkey, setPubkey] = useStatePersist('@pubkey', '')
  const loginWithPubkey = async (pubkey: string) => {
    const authed = await login(pubkey)
    if (authed && window.location.pathname === '/login') {
      console.log('Login successful')
      window.location.replace('/chat')
    }
  }
  useEffect(() => {
    // console.log('pubkey is:', pubkey)
    if (pubkey.length > 0) {
      loginWithPubkey(pubkey)
    }
  }, [pubkey])
  useEffect(() => {
    ;(async () => {
      const target = pubkey.length > 0 ? pubkey : undefined
      const connect = new Connect({
        secretKey,
        target,
        relay: 'wss://arc1.arcadelabs.co',
      })
      connect.events.on('connect', (pubkey: string) => {
        setPubkey(pubkey)

        console.log('Connected with pubkey:', pubkey)
      })
      connect.events.on('disconnect', () => {
        setPubkey('')
      })
      await connect.init()
    })()
  }, [])
}
