import React, { useEffect } from 'react'
import { generatePrivateKey, getPublicKey } from 'nostr-tools'
import { Connect, ConnectURI } from '@nostr-connect/connect'

// const privkey = generatePrivateKey()
// let webPK = getPublicKey(privkey) // `pk` is a hex string
// console.log(webPK)
const webPK = '9f8193e8e4047c7551122b13f1e5ea38ca46ba3b4ecdb912321200b48505601e'

export const ConnectDemo = () => {
  const createConnection = async () => {
    const sk = generatePrivateKey()
    const connect = new Connect({
      secretKey: sk,
      //   target: webPK,
      relay: 'wss://nostr.vulpem.com',
    })
    connect.events.on('connect', (walletPubkey: string) => {
      console.log('connected with wallet: ' + walletPubkey)
    })
    await connect.init()
    console.log('init?')

    const connectURI = new ConnectURI({
      target: webPK,
      relay: 'wss://nostr.vulpem.com',
      metadata: {
        name: 'Arcdex Web Demo 3',
        description: 'hello from the video 2',
        url: 'http://localhost:8000/chat',
        icons: ['https://thearcapp.com/img/logo.png'],
      },
    })

    const uri = connectURI.toString()
    console.log('uri: ' + uri)

    console.log('weaiting for 13 seconds')
    await sleep(13000)
    console.log('13 seconds up now lets check for pubkey')
    const pubkey = await connect.getPublicKey()
    console.log('PUBKEY:', pubkey)
  }

  const grabPublicKey = async (connectInstance: Connect) => {
    console.log('trying')
    if (!connectInstance) return
    console.log('Checking for pubkey')
    const pubkey = await connectInstance.getPublicKey()
    console.log('pubkey: ' + pubkey)
  }

  useEffect(() => {
    // console.log('lets test connect')
    // createConnection()
    // grabPublicKey()
    createConnection()
  }, [])
  return <h1 className="text-2xl text-white p-8">testing connect</h1>
}

export function sleep(ms: number) {
  return new Promise((resolve) => setTimeout(resolve, ms))
}
