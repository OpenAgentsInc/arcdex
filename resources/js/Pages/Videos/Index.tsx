import { usePage } from '@inertiajs/react'
import * as React from 'react'

export default function VideoIndex() {
  const videos = usePage().props.videos as any[]
  console.log(videos)
  return (
    <>
      {videos.map((video: any) => {
        return (
          <div key={video.id} className="text-white">
            <h1>{video.title}</h1>
            <p>{video.subtitle}</p>
          </div>
        )
      })}
    </>
  )
}

VideoIndex.layout = (page: React.ReactNode) => page
