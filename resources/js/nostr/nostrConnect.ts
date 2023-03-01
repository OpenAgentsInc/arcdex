import { ConnectURI } from '@nostr-connect/connect'
import { getPublicKey } from 'nostr-tools'

// export const secretKey = generatePrivateKey()
export const secretKey =
  '5acff99d1ad3e1706360d213fd69203312d9b5e91a2d5f2e06100cc6f686e5b3'

export const generateNostrConnectUri = () => {
  const connectURI = new ConnectURI({
    target: getPublicKey(secretKey),
    relay: 'wss://arc1.arcadelabs.co',
    metadata: {
      name: 'Arc',
      description: 'Arcdex web app',
      url: 'https://thearcapp.com',
      icons: ['https://thearcapp.com/img/logo.png'],
    },
  })

  return connectURI.toString()
}
