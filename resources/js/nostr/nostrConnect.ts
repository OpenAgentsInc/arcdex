import { ConnectURI } from '@nostr-connect/connect'
import { getPublicKey } from 'nostr-tools'

export const generateNostrConnectUri = () => {
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

  return connectURI.toString()
}
