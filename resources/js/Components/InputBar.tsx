import * as React from 'react'
import {
  broadcastToRelay,
  connectToRelay,
  TimeRanges,
} from '@nostr-connect/connect'
import { useForm, usePage } from '@inertiajs/react'
import {
  generatePrivateKey,
  getEventHash,
  getPublicKey,
  nip26,
  signEvent,
  UnsignedEvent,
} from 'nostr-tools'
import { useStore } from '../store'
import { webPK } from '../login/LoginScreen'
import { secretKey } from '../Layout'
import { isDelegatedEventValid } from '../nostr'
import { Event } from '../nostr/@types/event'
import { EventKinds } from '../nostr/constants/base'
import { getDelegator } from '../nostr/getDelegator'
import { useDelegation } from '../hooks/useDelegation'

export const InputBar = () => {
  const { channel } = usePage().props as any

  const { sendDelegatedEvent } = useDelegation()

  const { data, setData, post, processing, errors } = useForm({
    content: '',
    eventid: '',
    relayurl: '',
  })

  const connect = useStore((state) => state.connect)

  const sendMessage = async (e) => {
    e.preventDefault()
    console.log('Sending message...')
    if (!connect) {
      console.log('no connect')
      return
    }

    sendDelegatedEvent(channel, data.content)

    return

    const pk = await connect.getPublicKey()
    console.log('pk:', pk)
    const until = Math.round(Date.now() / 1000) + 60 * 60 // TimeRanges.ONE_HR
    const now = Math.floor(Date.now() / 1000)

    // TEST CREATE OUR OWN DELEGATION
    const delegatee = webPK
    // const conditions = {
    //   kind: 42,
    //   until,
    //   since: now - 1,
    // }

    const conditions = {
      kind: 42,
      until: 1677103886,
      since: 1677100285,
    }

    // console.log('delegatee:', webPK)
    const delegationSig = await connect.delegate(webPK, conditions)
    // console.log('delegationSig:', delegationSig)

    // const delegateParameters: nip26.Parameters = {
    //   pubkey: delegatee,
    //   kind: conditions.kind,
    //   since: conditions.since || Math.round(Date.now() / 1000),
    //   until:
    //     conditions.until ||
    //     Math.round(Date.now() / 1000) + 60 * 60 * 24 * 30 /* 30 days */,
    // }

    // let sk1 = generatePrivateKey()
    // let pk1 = getPublicKey(sk1)
    // const delegation = nip26.createDelegation(sk1, delegateParameters)
    // console.log(delegation)

    const condString = `kind=42&created_at>${conditions.since}&created_at<${conditions.until}`
    // const condString = 'kind=42&created_at>1677100285&created_at<1677103886'
    let event: Partial<Event> = {
      content: data.content,
      created_at: now + 1,
      kind: EventKinds.CHANNEL_MESSAGE,
      tags: [
        // ['e', channel.eventid, channel.relayurl, 'root'],
        ['delegation', pk, condString, delegationSig],
        // ['delegation', pk1, delegation.cond, delegation.sig],
      ],
      pubkey: webPK,
    }
    const eventWithId = { ...event, id: getEventHash(event as any) }
    const signedEvent = {
      ...eventWithId,
      sig: signEvent(eventWithId as any, secretKey),
    } as Event

    // console.log('DID WE SIGN THAT?????', signedEvent.sig)
    // console.log('FULL EVENT TO SEND MAYBE:', signedEvent)

    // const testEvent = {
    //   id: 'a080fd288b60ac2225ff2e2d815291bd730911e583e177302cc949a15dc2b2dc',
    //   pubkey:
    //     '62903b1ff41559daf9ee98ef1ae67cc52f301bb5ce26d14baba3052f649c3f49',
    //   created_at: 1660896109,
    //   kind: 1,
    //   tags: [
    //     [
    //       'delegation',
    //       '86f0689bd48dcd19c67a19d994f938ee34f251d8c39976290955ff585f2db42e',
    //       'kind=1&created_at>1640995200',
    //       'c33c88ba78ec3c760e49db591ac5f7b129e3887c8af7729795e85a0588007e5ac89b46549232d8f918eefd73e726cb450135314bfda419c030d0b6affe401ec1',
    //     ],
    //   ],
    //   content: 'Hello world',
    //   sig: 'cd4a3cd20dc61dcbc98324de561a07fd23b3d9702115920c0814b5fb822cc5b7c5bcdaf3fa326d24ed50c5b9c8214d66c75bae34e3a84c25e4d122afccb66eb6',
    // }
    // const valid = await isDelegatedEventValid(testEvent)
    // console.log(true)

    const delegator = getDelegator(signedEvent)
    console.log('delegator:', delegator)

    return

    const valid = await isDelegatedEventValid(signedEvent)
    console.log(signedEvent)

    console.log('VALID????', valid)
    return
    if (!valid) {
      //   throw new Error('Delegated event is not valid')
    }

    const relayurl = channel.relayurl
    const relay = await connectToRelay(relayurl)
    console.log('broadcasting to relay:', relayurl)
    await broadcastToRelay(relay, signedEvent, false)

    data.eventid = signedEvent.id
    data.relayurl = relayurl

    post(`/api/channel/${channel.id}/messages`)
  }

  return (
    <div
      id="input-bar"
      className="sm:absolute fixed bottom-0 left-0 w-full border-t md:border-t-0 dark:border-white/20 md:border-transparent md:dark:border-transparent md:bg-vert-light-gradient bg-white dark:bg-gray-800 md:!bg-transparent dark:md:bg-vert-dark-gradient"
    >
      <form
        onSubmit={sendMessage}
        className="stretch mx-2 flex flex-row gap-3 pt-2 last:mb-2 md:last:mb-6 lg:mx-auto lg:max-w-3xl lg:pt-6"
      >
        <div className="relative flex h-full flex-1 md:flex-col">
          <div className="flex flex-col w-full py-2 flex-grow md:py-3 md:pl-4 relative border border-black/10 bg-white dark:border-gray-900/50 dark:text-white dark:bg-gray-700 rounded-md shadow-[0_0_10px_rgba(0,0,0,0.10)] dark:shadow-[0_0_15px_rgba(0,0,0,0.10)]">
            <textarea
              id="message-input"
              //   onKeyDown={onKeyDown}
              value={data.content}
              onChange={(e) => setData('content', e.target.value)}
              tabIndex={0}
              rows={1}
              className="resize-none m-0 w-full border-0 bg-transparent p-0 pl-2 pr-7 focus:ring-0 focus-visible:ring-0 dark:bg-transparent md:pl-0"
              style={{ maxHeight: 200, overflowY: 'hidden' }}
            ></textarea>
            <button
              id="send-message"
              type="submit"
              className="absolute p-1 rounded-md text-gray-500 bottom-1.5 right-1 md:bottom-2.5 md:right-2 hover:bg-gray-100 dark:hover:text-gray-400 dark:hover:bg-gray-900 disabled:hover:bg-transparent dark:disabled:hover:bg-transparent"
            >
              <svg
                stroke="currentColor"
                fill="none"
                strokeWidth="2"
                viewBox="0 0 24 24"
                strokeLinecap="round"
                strokeLinejoin="round"
                className="h-4 w-4 mr-1"
                height="1em"
                width="1em"
                xmlns="http://www.w3.org/2000/svg"
              >
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
              </svg>
            </button>
          </div>
        </div>
      </form>
    </div>
  )
}
