import * as React from 'react'
import { BetaHero } from './BetaHero'
import { Footer } from './Footer'

export default function BetaPage() {
  return (
    <div className="bg-gray-900 min-h-screen flex flex-col">
      <main className="grow">
        <BetaHero />
      </main>
      <Footer />
    </div>
  )
}

BetaPage.layout = (page: React.ReactNode) => page
