import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'
import { useNostrConnect } from './hooks/useNostrConnect'
import { Layout } from './Layout'

const Provider = ({ children }) => {
  useNostrConnect()
  return <>{children}</>
}

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.tsx', { eager: true })
    let page = pages[`./Pages/${name}.tsx`]
    page.default.layout =
      page.default.layout || ((page) => <Layout children={page} />)
    return page
  },
  setup({ el, App, props }) {
    createRoot(el).render(
      <Provider>
        <App {...props} className="h-full" />
      </Provider>
    )
  },
})
