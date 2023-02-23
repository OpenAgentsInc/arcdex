import { useMemo } from 'react'
import { generateNostrConnectUri } from '../nostr/nostrConnect'

export function useNostrConnectUri() {
  const nostrConnectUri = useMemo(() => {
    return generateNostrConnectUri()
  }, [])

  return nostrConnectUri
}
