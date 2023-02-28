import { relayInit } from 'nostr-tools'

export const checkRelayForUserMetadata = async (
  pubkey: string,
  relayUrl = 'wss://arc1.arcadelabs.co'
) => {
  const relay = relayInit(relayUrl)
  relay.on('connect', () => {
    console.log(`connected to ${relay.url}`)
  })
  relay.on('error', () => {
    console.log(`failed to connect to ${relay.url}`)
  })

  await relay.connect()

  return new Promise((resolve, reject) => {
    let sub = relay.sub([
      {
        kinds: [0],
        // authors: [pubkey],
        // since 20 minutes ago
        since: Math.floor(Date.now() / 1000) - 60 * 20,
      },
    ])
    sub.on('event', (event) => {
      console.log('Found:', event)
      resolve(event)
    })
    sub.on('eose', () => {
      console.log('eose')
      sub.unsub()
      console.log('Sub connection closed...')
      // reject(new Error('Sub connection closed'))
    })
  })
}
