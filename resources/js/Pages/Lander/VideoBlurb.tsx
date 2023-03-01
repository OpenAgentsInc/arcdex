import * as React from 'react'

export const VideoBlurb = ({ video }: { video: any }) => {
  return (
    <a
      href={`/video/${video.id}`}
      className="mt-12 max-w-md scale-100 p-4 sm:p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-indigo-500"
    >
      <div className="flex-grow">
        <h2 className="text-md font-semibold text-gray-900 dark:text-white">
          Building Arc #{video.id}: {video.title}
        </h2>

        <p className="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
          {video.subtitle}
        </p>
      </div>
    </a>
  )
}
