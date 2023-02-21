import * as React from 'react'
import { useEffect, useState } from 'react'
import { useStatePersist } from 'use-state-persist'
import {
  broadcastToRelay,
  Connect,
  connectToRelay,
  ConnectURI,
} from '@nostr-connect/connect'
import { useStore } from './store'
import { getPublicKey } from 'nostr-tools'

const secretKey =
  '5acff99d1ad3e1706360d213fd69203312d9b5e91a2d5f2e06100cc6f686e5b3'
const connectURI = new ConnectURI({
  target: getPublicKey(secretKey),
  relay: 'wss://nostr.vulpem.com',
  metadata: {
    name: 'Arc',
    description: 'Arcdex web app',
    url: 'https://thearcapp.com',
    icons: ['https://thearcapp.com/img/logo.png'],
  },
})

export const Layout = ({ children }: { children: React.ReactNode }) => {
  const [persistedPubkey] = useStatePersist('@pubkey', '')
  const pubkey = useStore((state) => state.pubkey)
  const setPubkey = useStore((state) => state.setPubkey)
  const setConnect = useStore((state) => state.setConnect)

  const [getPublicKeyReply, setGetPublicKeyReply] = useState('')
  const [eventWithSig, setEvent] = useState({})
  const [schnorrSig, setSchnorrSig] = useState('')

  useEffect(() => {
    console.log('Hello from the layout. Pubkey is: ', pubkey)
    // console.log('Persisted pubkey is: ', persistedPubkey)
    // if we have persistedPubkey but not pubkey, set pubkey to persistedPubkey
    if (persistedPubkey.length > 0 && pubkey.length === 0) {
      setPubkey(persistedPubkey)
    }
  }, [pubkey, persistedPubkey])

  useEffect(() => {
    if (!pubkey) return
    ;(async () => {
      const target = pubkey.length > 0 ? pubkey : undefined
      const connect = new Connect({
        secretKey,
        target,
      })
      connect.events.on('connect', (pubkey: string) => {
        setPubkey(pubkey)
      })
      connect.events.on('disconnect', () => {
        setEvent({})
        setPubkey('')
        setGetPublicKeyReply('')
      })
      await connect.init()
      setConnect(connect)
      console.log('Initialized')
    })()
  }, [pubkey])

  const copyToClipboard = () => {
    navigator.clipboard.writeText(connectURI.toString()).then(
      () => {
        console.log('copied', connectURI.toString())
      },
      function (err) {
        console.error('Async: Could not copy text: ', err)
      }
    )
  }

  return (
    <div>
      <div className="flex flex-col items-center justify-center w-full h-4 bg-gray-400">
        <button onClick={copyToClipboard}>Copy connect URI to clipboard</button>
      </div>
      {/* <h1 className="ml-32 max-w-4xl text-white text-sm">
        {connectURI.toString()}
      </h1> */}

      {children}
    </div>
  )
}
