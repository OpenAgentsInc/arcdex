// import './bootstrap'
import React from 'react'
import { createRoot } from 'react-dom/client'
import Main from './Main'

console.log('test')

const app = document.getElementById('root')
createRoot(app).render(<Main />)
