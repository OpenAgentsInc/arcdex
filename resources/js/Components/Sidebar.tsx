import * as React from 'react'
import { usePage } from '@inertiajs/react'
import { NewChannelForm } from './NewChannelForm'
import { ChannelDetail } from './ChannelDetail'
import { useStore } from '../store'
import { useStatePersist } from 'use-state-persist'

export const Sidebar = () => {
  const { channels } = usePage().props
  const logout = useStore((state) => state.logout)
  const [, setPubkey] = useStatePersist('@pubkey', '')
  const clickedLogout = () => {
    logout(setPubkey)
  }
  return (
    <div className="flex bg-gray-900">
      <div className="hidden md:flex md:flex-shrink-0 ">
        <div className="flex flex-col w-64 border-r border-gray-700 px-1">
          <div className="h-0 flex-1 flex flex-col overflow-y-auto overflow-x-hidden nice-scrollbar">
            <nav className="flex h-full flex-1 flex-col space-y-1">
              <div className="p-3 border-b border-gray-700">
                <NewChannelForm />
              </div>
              <div className="px-2 space-y-2 flex-col flex-1 overflow-y-auto nice-scrollbar">
                <div className="pt-3 mb-3 flex flex-row items-center justify-between text-sm">
                  <span className="font-bold text-indigo-400">Channels</span>
                  <span className="flex items-center justify-center bg-gray-700 text-gray-200 h-6 w-6 rounded-full">
                    {channels.length}
                  </span>
                </div>
                {channels.map((channel) => (
                  <ChannelDetail key={channel.id} channel={channel} />
                ))}
              </div>
            </nav>
          </div>
          <button
            onClick={clickedLogout}
            className="h-12 flex items-center justify-center w-full text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
          >
            Log out
          </button>
        </div>
      </div>
    </div>
  )
}
