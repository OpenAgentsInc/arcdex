import * as React from 'react'
import { broadcastToRelay, connectToRelay } from '@nostr-connect/connect'
import { useForm, usePage } from '@inertiajs/react'
import { useStore } from '../store'
import { useDelegation } from '../hooks/useDelegation'

export const InputBar = () => {
  const { channel } = usePage().props as any
  const { signDelegatedEvent } = useDelegation()
  const connect = useStore((state) => state.connect)
  const { data, setData, post } = useForm({
    content: '',
    eventid: '',
    relayurl: '',
  })

  const sendMessage = async (e) => {
    e.preventDefault()
    console.log('Sending message...')
    if (!connect) {
      console.log('no connect')
      return
    }

    const signedEvent = await signDelegatedEvent(channel, data.content)
    if (!signedEvent) {
      console.log('no signed event')
      return
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
