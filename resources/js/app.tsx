// import './bootstrap'
import React from 'react'
import { createRoot } from 'react-dom/client'
import { ConnectDemo } from './ConnectDemo'
// import Main from './Main'

const app = document.getElementById('root') as HTMLElement
createRoot(app).render(<ConnectDemo />)
