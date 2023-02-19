import '../bootstrap'
import * as React from 'react'
import { createRoot } from 'react-dom/client'
import { LoginScreen } from './LoginScreen'

const app = document.getElementById('root') as HTMLElement
createRoot(app).render(<LoginScreen />)
