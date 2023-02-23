import * as React from 'react'
import { useEffect, useState } from 'react'
import { useStatePersist } from 'use-state-persist'
import {
  broadcastToRelay,
  Connect,
  connectToRelay,
  ConnectURI,
} from '@nostr-connect/connect'
import axios from 'axios'

import { QRCodeSVG } from 'qrcode.react'
import { getEventHash, getPublicKey, Event } from 'nostr-tools'

const secretKey =
  '5acff99d1ad3e1706360d213fd69203312d9b5e91a2d5f2e06100cc6f686e5b3'
export const webPK = getPublicKey(secretKey)

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

export const LoginScreen = () => {
  const [pubkey, setPubkey] = useStatePersist('@pubkey', '')
  const [getPublicKeyReply, setGetPublicKeyReply] = useState('')
  const [eventWithSig, setEvent] = useState({})
  const [schnorrSig, setSchnorrSig] = useState('')

  const logout = async () => {
    console.log('logging out...')
    await disconnect()
    await axios.post(
      '/logout',
      {},
      {
        headers: {
          'Content-Type': 'application/json',
        },
      }
    )
    console.log('logged out?')
  }

  const fetchChannels = async () => {
    const res = await axios.get('/api/channels', {
      headers: {
        'Content-Type': 'application/json',
      },
    })

    console.log('res: ', res.data)
  }

  const login = async () => {
    await axios.get('/sanctum/csrf-cookie', {
      headers: {
        'Content-Type': 'application/json',
      },
    })

    console.log(pubkey)

    try {
      const res2 = await axios.post(
        '/login',
        {
          pubkey,
        },
        {
          headers: {
            'Content-Type': 'application/json',
          },
        }
      )

      console.log('res2: ', res2.data)
    } catch (error) {
      alert(error.response.data.errors.user)
    }
  }

  useEffect(() => {
    ;(async () => {
      const target = pubkey.length > 0 ? pubkey : undefined
      const connect = new Connect({
        secretKey,
        target,
      })
      connect.events.on('connect', (pubkey: string) => {
        setPubkey(pubkey)

        console.log('Connected with pubkey:', pubkey)
      })
      connect.events.on('disconnect', () => {
        setEvent({})
        setPubkey('')
        setGetPublicKeyReply('')
      })
      await connect.init()
    })()
  }, [])

  const getPub = async () => {
    if (pubkey.length === 0) return
    const connect = new Connect({
      secretKey,
      target: pubkey,
    })
    const pk = await connect.getPublicKey()
    setGetPublicKeyReply(pk)
    console.log('We grabbed the public key: ', pk)
  }

  const sendMessage = async () => {
    try {
      if (pubkey.length === 0) return

      const connect = new Connect({
        secretKey,
        target: pubkey,
      })

      let event: Event = {
        kind: 1,
        pubkey: pubkey,
        created_at: Math.floor(Date.now() / 1000),
        tags: [],
        content: 'Running Nostr Connect 🔌',
      }
      event.id = getEventHash(event)
      event.sig = await connect.signEvent(event)
      const relay = await connectToRelay('wss://relay.damus.io')
      await broadcastToRelay(relay, event, true)

      setEvent(event)
    } catch (error) {
      console.error(error)
    }
  }

  const getSchnorrSig = async () => {
    try {
      if (pubkey.length === 0) return

      const connect = new Connect({
        secretKey,
        target: pubkey,
      })

      const sig = await connect.rpc.call({
        target: pubkey,
        request: {
          method: 'sign_schnorr',
          params: ['Hello World'],
        },
      })
      setSchnorrSig(sig)
    } catch (error) {
      console.error(error)
    }
  }

  const isConnected = () => {
    return pubkey.length > 0
  }

  const disconnect = async () => {
    const connect = new Connect({
      secretKey,
      target: pubkey,
    })
    await connect.disconnect()
    //cleanup
    setEvent({})
    setPubkey('')
    setGetPublicKeyReply('')
  }

  const copyToClipboard = () => {
    navigator.clipboard
      .writeText(connectURI.toString())
      .then(undefined, function (err) {
        console.error('Async: Could not copy text: ', err)
      })
  }

  return (
    <div className="hero is-fullheight has-background-black has-text-white">
      <section className="container">
        <div className="content">
          <h1 className="title has-text-white">Nostr Connect Playground</h1>
        </div>
        <div className="content">
          <p className="subtitle is-6 has-text-white">
            <b>Nostr ID</b> {getPublicKey(secretKey)}
          </p>
        </div>
        <div className="content">
          <p className="subtitle is-6 has-text-white">
            <b>Status</b> {isConnected() ? '🟢 Connected' : '🔴 Disconnected'}
          </p>
        </div>
        {isConnected() && (
          <div className="content">
            <button className="button is-danger" onClick={disconnect}>
              <p className="subtitle is-6 has-text-white">
                💤 <i>Disconnect</i>
              </p>
            </button>
          </div>
        )}
        {!isConnected() && (
          <div className="content has-text-centered">
            <div className="notification is-dark">
              <h2 className="title is-5">Connect with Nostr</h2>

              <QRCodeSVG value={connectURI.toString()} />
              <input
                className="input is-info"
                type="text"
                value={connectURI.toString()}
                readOnly
              />
              <button className="button is-info mt-3" onClick={copyToClipboard}>
                Copy to clipboard
              </button>
            </div>
          </div>
        )}
        {isConnected() && (
          <div className="flex flex-col">
            <div className="max-w-xl bg-gray-800 flex justify-center items-center py-6 rounded-xl m-4 space-x-6">
              <button
                type="button"
                className="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                onClick={login}
              >
                Log in
              </button>
              <button
                type="button"
                className="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                onClick={fetchChannels}
              >
                Fetch channels
              </button>
              <button
                type="button"
                className="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                onClick={logout}
              >
                Log out
              </button>
            </div>

            <div className="content">
              <h2 className="title is-5 has-text-white">Get Public Key</h2>
              <button
                className="button is-info has-text-white"
                onClick={getPub}
              >
                Get public key
              </button>
              {getPublicKeyReply.length > 0 && (
                <input
                  className="input is-info mt-3"
                  type="text"
                  value={getPublicKeyReply}
                  readOnly
                />
              )}
            </div>
            <div className="content">
              <h2 className="title is-5 has-text-white">
                Post a message on Damus relay with text{' '}
                <b>Running Nostr Connect 🔌</b>
              </h2>
              <button className="button is-info" onClick={sendMessage}>
                Sign Event
              </button>
              {Object.keys(eventWithSig).length > 0 && (
                <textarea
                  className="textarea"
                  readOnly
                  rows={12}
                  defaultValue={JSON.stringify(eventWithSig, null, 2)}
                />
              )}
            </div>
            <div className="content">
              <h2 className="title is-5 has-text-white">
                Get a Schnorr signature for the message <b>Hello World</b>
              </h2>
              <button className="button is-info" onClick={getSchnorrSig}>
                Sign Schnorr
              </button>
              {Object.keys(schnorrSig).length > 0 && (
                <input
                  className="input is-info mt-3"
                  type="text"
                  value={schnorrSig}
                  readOnly
                />
              )}
            </div>
          </div>
        )}
      </section>
    </div>
  )
}

// import * as React from 'react'

// export const LoginScreen = () => {
//   return (
//     <div className="flex flex-col items-center justify-center h-screen">
//       <div className="flex flex-col items-center justify-center bg-gray-900 rounded-lg p-4">
//         <h1 className="text-2xl text-white p-8">Login</h1>
//         <div className="flex flex-col items-center justify-center">
//           <input
//             className="bg-gray-800 rounded-lg p-2"
//             type="text"
//             placeholder="Username"
//           />
//           <button className="bg-gray-800 rounded-lg p-2 mt-4">Login</button>
//         </div>
//       </div>
//     </div>
//   )
// }
