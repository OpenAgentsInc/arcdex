import * as React from 'react'
import { useNostrConnect } from '../hooks/useNostrConnect'
import { NostrConnectButton } from './NostrConnectButton'
import { NostrConnectExplainer } from './NostrConnectExplainer'

export const LoginScreen = () => {
  useNostrConnect()
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
