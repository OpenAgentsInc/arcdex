import * as React from 'react'

export const LoginScreen = () => {
  return (
    <div className="text-white h-full w-full bg-gray-900 flex flex-col justify-center items-center space-y-10">
      <img
        className="mb-8"
        src="/img/logo.png"
        alt="logo"
        style={{ height: 150 }}
      />
      <button
        type="button"
        className="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
      >
        Log in with Nostr Connect
      </button>

      <a href="https://github.com/nostr-protocol/nips/pull/153" target="_blank">
        <p className="text-indigo-300/75 italic text-sm">
          What is Nostr Connect?
        </p>
      </a>

      {/* <p>Status: Disconnected</p> */}

      {/* <p>ConnectURI</p> */}
      {/* <p>QR Code</p> */}
    </div>
  )
}
