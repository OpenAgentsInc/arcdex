import { usePage } from '@inertiajs/react'
import * as React from 'react'
import { Glow } from '../Lander/Glow'
import { Video } from './Video'

export default function VideoIndex() {
  const videos = usePage().props.videos as any[]
  return (
    <div className="h-screen flex overflow-hidden bg-cool-gray-100">
      <main
        className="flex-1 relative z-0 overflow-y-auto focus:outline-none nice-scrollbar"
        tabIndex={0}
      >
        <div className="max-w-7xl mx-auto py-4 lg:p-8">
          <div className="my-4 flex flex-col justify-center items-center">
            <a href="/">
              <img
                src="/img/logo.png"
                alt="logo"
                className="w-auto bg-gray-100 dark:bg-gray-900"
                style={{ height: 130 }}
              />
            </a>

            <h1 className="text-2xl text-center dark:text-white font-bold mt-6 mb-4">
              Building Arc
            </h1>
            <h3 className="text-gray-500 dark:text-gray-400">
              Let's build an awesome Nostr app.
            </h3>
          </div>

          <div className="mx-auto h-full">
            <div className="p-4 lg:p-8">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                {videos.map((video: any) => {
                  return <Video video={video} key={video.id} />
                })}
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  )
}

VideoIndex.layout = (page: React.ReactNode) => page
