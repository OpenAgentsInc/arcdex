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
import { Sidebar } from './Components/Sidebar'

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
    // console.log('Hello from the layout. Pubkey is: ', pubkey)
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
      //   console.log('Initialized')
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
    // <div className="flex flex-col h-full w-full dark:bg-gray-800 overflow-hidden items-stretch flex-1">
    <div className="h-screen flex overflow-hidden bg-cool-gray-100">
      <Sidebar />
      <div className="flex flex-col w-0 flex-1 overflow-hidden">
        <div className="md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3">
          <button
            className="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150"
            aria-label="Open sidebar"
          >
            <svg
              className="h-6 w-6"
              stroke="currentColor"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M4 6h16M4 12h16M4 18h16"
              ></path>
            </svg>
          </button>
        </div>

        <main
          className="flex-1 relative z-0 overflow-y-auto focus:outline-none nice-scrollbar"
          tabIndex={0}
        >
          <div className="mx-auto h-full">{children}</div>
        </main>
      </div>
    </div>
    // </div>
  )
}
