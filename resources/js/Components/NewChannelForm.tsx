import * as React from 'react'
import { broadcastToRelay, connectToRelay } from '@nostr-connect/connect'
import { useForm } from '@inertiajs/react'
import { Event, getEventHash } from 'nostr-tools'
import { useStore } from '../store'

export const NewChannelForm = () => {
  const { data, setData, post, processing, errors } = useForm({
    title: '',
    eventid: '',
    relayurl: '',
  })

  const connect = useStore((state) => state.connect)

  const createChannel = async (e) => {
    e.preventDefault()
    if (!connect) {
      console.log('no connect')
      return
    }
    let chan = {}
    chan['about'] = 'A demo channel'
    chan['name'] = data.title
    chan['picture'] = 'https://placekitten.com/200/200'
    const now = Math.floor(Date.now() / 1000)
    const note = JSON.stringify(chan)
    let event: Event = {
      content: note,
      created_at: now,
      kind: 40,
      tags: [],
      pubkey:
        '696da2ff3bab02510a3e4a5b70d370140774e174f3a0ebf5d2dc8a376d1232ec',
    }
    event.id = getEventHash(event)
    event.sig = await connect.signEvent(event)
    const relayurl = 'wss://nostr.vulpem.com'
    const relay = await connectToRelay(relayurl)
    await broadcastToRelay(relay, event, true)

    data.eventid = event.id
    data.relayurl = relayurl

    post('/api/channels')
  }

  return (
    <div className="w-full px-1">
      <form onSubmit={createChannel}>
        <input
          type="text"
          value={data.title}
          onChange={(e) => setData('title', e.target.value)}
          className="mb-2 border-gray-700 w-full px-4 py-2 text-gray-700 dark:text-gray-200 rounded-xl bg-transparent focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50"
          spellCheck="false"
        />
        {errors.title && (
          <div className="text-sm text-red-500">{errors.title}</div>
        )}
        <button
          type="submit"
          className="bg-origin-border inline-flex items-center justify-center rounded-xl w-full p-2 text-white bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50"
        >
          <div className="-ml-6 mr-3 w-4 h-4">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              strokeWidth="1.5"
              stroke="currentColor"
              className="w-4 h-4 opacity-75"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"
              />
            </svg>
          </div>
          New Channel
        </button>
      </form>
    </div>
  )
}
