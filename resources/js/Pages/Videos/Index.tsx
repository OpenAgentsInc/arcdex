import { usePage } from '@inertiajs/react'
import * as React from 'react'
import { Video } from './Video'

export default function VideoIndex() {
  const videos = usePage().props.videos as any[]
  return (
    <div className="h-screen flex overflow-hidden bg-cool-gray-100">
      <main
        className="flex-1 relative z-0 overflow-y-auto focus:outline-none nice-scrollbar"
        tabIndex={0}
      >
        <div className="mx-auto h-full">
          <div className="p-12">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
              {videos.map((video: any) => {
                return <Video video={video} key={video.id} />
              })}
            </div>
          </div>
        </div>
      </main>
    </div>
  )
}

VideoIndex.layout = (page: React.ReactNode) => page
