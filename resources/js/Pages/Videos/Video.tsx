import * as React from 'react'

export const Video = ({ video }) => (
  <a
    href={`/video/${video.id}`}
    className="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-indigo-500"
  >
    <div className="flex-grow">
      <div className="h-12 w-12 bg-indigo-50 dark:bg-indigo-800/20 flex flex-grow items-center justify-center rounded-full">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          strokeWidth="1.5"
          className="w-6 h-6 stroke-indigo-500"
        >
          <path
            strokeLinecap="round"
            d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"
          />
        </svg>
      </div>

      <h2 className="mt-6 text-xl font-semibold text-gray-900 dark:text-white">
        #{video.id}: {video.title}
      </h2>

      <p className="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
        {video.subtitle}
      </p>
    </div>

    <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      strokeWidth="1.5"
      className="self-center shrink-0 stroke-indigo-500 w-6 h-6 mx-6"
    >
      <path
        strokeLinecap="round"
        strokeLinejoin="round"
        d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
      />
    </svg>
  </a>
)
