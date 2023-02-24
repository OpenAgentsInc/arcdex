import * as React from 'react'
import { DarkHero } from './DarkHero'
import { Footer } from './Footer'

export default function HomePage() {
  return (
    <div className="bg-gray-900">
      <main>
        <DarkHero />
        <Footer />
      </main>
    </div>
  )
}

HomePage.layout = (page: React.ReactNode) => page
