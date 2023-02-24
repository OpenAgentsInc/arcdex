import {
  Event,
  getEventHash,
  getPublicKey,
  signEvent,
  UnsignedEvent,
} from 'nostr-tools'
import { Delegation, getDelegator } from 'nostr-tools/nip26'
import { useState } from 'react'
import { isDelegatedEventValid } from '../nostr'
import { EventKinds } from '../nostr/constants/base'
import { secretKey } from '../nostr/nostrConnect'
import { useStore } from '../store'

const webPK = getPublicKey(secretKey)
const generateConditions = () => {
  const now = Math.floor(Date.now() / 1000)
  return { kind: 42, until: now + 100000, since: now }
}

export function useDelegation() {
  const connect = useStore((state) => state.connect)
  const [savedDelegation, setDelegation] = useState<Delegation | null>(null)

  const signDelegatedEvent = async (channel: any, content: string) => {
    if (!connect) return

    const pk = await connect.getPublicKey()

    let delegation: Delegation | null = null

    // Check if there is a saved delegation.
    if (savedDelegation) {
      // Check if the delegation is still valid.
      console.log('WE HAVE A SAVEDDELEGATION. CHECK IT:', savedDelegation)

      const currentTime = Math.floor(Date.now() / 1000) // Get current time in seconds

      const conditions = savedDelegation.cond
      const matches = conditions.match(/created_at<(\d+)&created_at>(\d+)/)
      if (!matches) return
      console.log(matches)

      const minCreatedNum = Number(matches[2])
      const maxCreatedNum = Number(matches[1])

      if (currentTime > minCreatedNum && currentTime < maxCreatedNum) {
        console.log('Current time meets created_at conditions')
        delegation = savedDelegation
      } else {
        console.log('Current time does not meet created_at conditions')
        delegation = null
      }
    }

    if (!delegation) {
      delegation = (await connect.delegate(
        webPK,
        generateConditions()
      )) as unknown as Delegation

      setDelegation(delegation)
    }

    let event: UnsignedEvent = {
      content: content,
      created_at: Math.floor(Date.now() / 1000) + 1,
      kind: EventKinds.CHANNEL_MESSAGE as number,
      tags: [
        ['e', channel.eventid, channel.relayurl, 'root'],
        ['delegation', pk, delegation.cond, delegation.sig],
      ],
      pubkey: webPK,
    }
    const eventWithId = { ...event, id: getEventHash(event as any) }
    const signedEvent = {
      ...eventWithId,
      sig: signEvent(eventWithId as any, secretKey),
    } as Event

    const delegator = getDelegator(signedEvent)
    console.log(delegator)

    const valid = await isDelegatedEventValid(signedEvent as any)
    if (!valid) throw new Error('Delegated event is invalid.')

    console.log('Delegated event is valid.')
    return signedEvent
  }

  return {
    signDelegatedEvent,
  }
}
