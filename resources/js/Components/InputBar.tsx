import * as React from 'react'
import { broadcastToRelay, connectToRelay } from '@nostr-connect/connect'
import { useForm, usePage } from '@inertiajs/react'
import { Event, getEventHash } from 'nostr-tools'
import { useStore } from '../store'

export const InputBar = () => {
  const { channel } = usePage().props as any

  const { data, setData, post, processing, errors } = useForm({
    content: '',
    eventid: '',
    relayurl: '',
  })

  const connect = useStore((state) => state.connect)

  const sendMessage = async (e) => {
    e.preventDefault()
    console.log('Hello!')
    if (!connect) {
      console.log('no connect')
      return
    }
    // let chan = {}
    // chan['about'] = 'A demo channel'
    // chan['name'] = data.title
    // chan['picture'] = 'https://placekitten.com/200/200'
    const now = Math.floor(Date.now() / 1000)
    // const note = JSON.stringify(chan)
    let event: Event = {
      content: data.content,
      created_at: now,
      kind: 42,
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

    post(`/api/channel/${channel.id}/messages`)
  }

  //   const onKeyDown = (event) => {
  //     if (event.keyCode == 13 && !event.shiftKey) {
  //       event.preventDefault()
  //       document.getElementById('send-message')?.click()
  //     }
  //   }
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
