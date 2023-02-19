// import './bootstrap'
import React from 'react'
import { createRoot } from 'react-dom/client'
import Main from './Main'

const app = document.getElementById('root') as HTMLElement
createRoot(app).render(<Main />)

console.log('hello')
