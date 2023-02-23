import * as React from 'react'
import { formatDistanceToNow } from 'date-fns'

export const formatTimestamp = (timestamp: string) => {
  // eslint-disable-next-line radix
  const timestampNum = parseInt(timestamp)
  const date = new Date(timestampNum * 1000)
  const formattedTimestamp = formatDistanceToNow(date, { addSuffix: true })
  return formattedTimestamp
}

export const Message = ({ message }) => {
  //   console.log('In Message with:', message)
  return (
    <div
      className="flex flex-col bg-gray-900 my-4 py-2 px-3 rounded-lg"
      style={{ width: '60%' }}
    >
      <p className="text-indigo-500">{message.pubkey.substring(0, 10)}</p>
      <p className="text-gray-500">{message.content}</p>
      <p className="text-gray-500">
        {formatTimestamp(message.created_at.toString())}
      </p>
    </div>
  )
}
