import {
  Event,
  generatePrivateKey,
  getEventHash,
  getPublicKey,
  nip26,
  signEvent,
  UnsignedEvent,
} from 'nostr-tools'
import { Delegation, getDelegator } from 'nostr-tools/nip26'
import { isDelegatedEventValid } from '../nostr'
import { EventKinds } from '../nostr/constants/base'
import { useStore } from '../store'

const secretKey =
  '5acff99d1ad3e1706360d213fd69203312d9b5e91a2d5f2e06100cc6f686e5b3'
const webPK = getPublicKey(secretKey)
const generateConditions = () => {
  const now = Math.floor(Date.now() / 1000)
  return { kind: 42, until: now + 100000, since: now }
}

const generateDemoDelegation = async (sk) => {
  const delegateParameters: nip26.Parameters = {
    pubkey: webPK,
    ...generateConditions(),
  }
  const delegation = nip26.createDelegation(sk, delegateParameters)
  console.log('We have the delegation:', delegation)
  return delegation
}

export function useDelegation() {
  const connect = useStore((state) => state.connect)

  const sendDelegatedEvent = async (channel: any, content: string) => {
    if (!connect) return

    const pk = await connect.getPublicKey()
    const delegation = (await connect.delegate(
      webPK,
      generateConditions()
    )) as unknown as Delegation

    // let sk = generatePrivateKey()
    // const pk = getPublicKey(sk)
    // const delegation: Delegation = await generateDemoDelegation(sk)

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

    const valid = await isDelegatedEventValid(signedEvent)
    console.log('VALID?', valid)

    // 38abf38c4d4c29e671a63731799b81142f82784438ae024af5b0f70f1a23594c77bc6062c8c86921d3ccea226a72a2654596fbb865fd94399537653ba239f183
  }

  return {
    sendDelegatedEvent,
  }
}
