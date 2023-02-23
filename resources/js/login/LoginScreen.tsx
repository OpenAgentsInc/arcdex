import * as React from 'react'
import { NostrConnectButton } from './NostrConnectButton'
import { NostrConnectExplainer } from './NostrConnectExplainer'

export const LoginScreen = () => {
  return (
    <div className="font-sans text-white h-full w-full bg-gray-900 flex flex-col justify-center items-center space-y-10">
      <img
        className="mb-8"
        src="/img/logo.png"
        alt="logo"
        style={{ height: 150 }}
      />
      <NostrConnectButton />
      <NostrConnectExplainer />
    </div>
  )
}
