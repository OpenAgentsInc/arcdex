import * as React from 'react'
import { usePage } from '@inertiajs/react'

export default function ChatHome() {
  const { channels } = usePage().props
  return (
    <div>
      <h1>Channel list</h1>
      {channels.length > 0 ? (
        <ul>
          {channels.map((channel) => (
            <li key={channel.id}>{channel.title}</li>
          ))}
        </ul>
      ) : (
        <p>No channels yet.</p>
      )}
    </div>
  )
}
