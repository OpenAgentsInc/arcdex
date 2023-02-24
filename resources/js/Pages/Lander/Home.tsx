import * as React from 'react'
import { DarkHero } from './DarkHero'
import { Footer } from './Footer'

export default function HomePage() {
  return (
    <div className="bg-gray-900 min-h-screen flex flex-col">
      <main className="grow">
        <DarkHero />
      </main>
      <Footer />
    </div>
  )
}

HomePage.layout = (page: React.ReactNode) => page
