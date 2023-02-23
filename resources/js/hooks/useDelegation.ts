import {
  Event,
  getEventHash,
  getPublicKey,
  signEvent,
  UnsignedEvent,
} from 'nostr-tools'
import { Delegation, getDelegator } from 'nostr-tools/nip26'
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

  const signDelegatedEvent = async (channel: any, content: string) => {
    if (!connect) return

    const pk = await connect.getPublicKey()
    const delegation = (await connect.delegate(
      webPK,
      generateConditions()
    )) as unknown as Delegation

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
