import { Connect } from '@nostr-connect/connect'
import axios from 'axios'
import { secretKey } from './nostr/nostrConnect'

const disconnect = async () => {
  const connect = new Connect({
    secretKey,
    target: pubkey,
  })
  await connect.disconnect()
  //cleanup
  // setEvent({})
  // setPubkey('')
  // setGetPublicKeyReply('')
}

export const logout = async () => {
  console.log('logging out...')
  await disconnect()
  await axios.post(
    '/logout',
    {},
    {
      headers: {
        'Content-Type': 'application/json',
      },
    }
  )
  console.log('logged out?')
}

export const login = async (pubkey: string) => {
  await axios.get('/sanctum/csrf-cookie', {
    headers: {
      'Content-Type': 'application/json',
    },
  })

  try {
    const res2 = await axios.post(
      '/login',
      {
        pubkey,
      },
      {
        headers: {
          'Content-Type': 'application/json',
        },
      }
    )

    // console.log('res2: ', res2.data)
  } catch (error) {
    alert(error.response.data.errors.user)
  }
  return true
}
