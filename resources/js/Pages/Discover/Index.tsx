import { usePage } from '@inertiajs/react'
import axios from 'axios'
import * as React from 'react'

export default function DiscoverPage() {
  const { discoverChannels } = usePage().props as any

  const filteredChannels = discoverChannels.filter(
    (channel) => channel.title !== ''
  )

  return (
    <div className="p-8">
      <h1 className="text-white text-center font-bold mt-4 mb-12 text-2xl">
        Discover Channels
      </h1>
      <ul
        role="list"
        className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 text-white"
      >
        {filteredChannels.map((person) => (
          <li
            key={person.id}
            className="col-span-1 divide-y divide-indigo-500 rounded-lg bg-indigo-900/75 shadow"
          >
            <div className="flex w-full items-center justify-between space-x-6 p-6">
              <div className="flex-1 truncate">
                <div className="flex items-center space-x-3">
                  <h3 className="truncate text-sm font-medium text-gray-900">
                    {person.name}
                  </h3>
                </div>
                <p className="mt-1 truncate text-sm text-white">
                  {person.title}
                </p>
              </div>
              <img
                className="h-10 w-10 flex-shrink-0 rounded-full bg-gray-300"
                src="https://placekitten.com/200/200"
                alt=""
              />
            </div>
            <div>
              <div className="-mt-px flex divide-x divide-indigo-500">
                <div className="flex w-0 flex-1">
                  <a
                    // href={`mailtio:${person.email}`}
                    onClick={() => {
                      axios.post(`/api/channels/${person.id}/join`)
                    }}
                    className="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium text-indigo-300 hover:text-gray-500"
                  >
                    <span className="ml-3">Join</span>
                  </a>
                </div>
              </div>
            </div>
          </li>
        ))}
      </ul>
    </div>
  )
}
