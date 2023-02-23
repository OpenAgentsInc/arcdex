import { Buffer } from 'buffer'
import * as secp256k1 from '@noble/secp256k1'
import {
  converge,
  curry,
  mergeLeft,
  nth,
  omit,
  pipe,
  prop,
  reduceBy,
} from 'ramda'
import { Event } from './@types/event'
import { EventTags } from './constants/base'
import { RuneLike } from './runes/rune-like'

export const isDelegatedEventValid = async (event: Event): Promise<boolean> => {
  console.log('Checking to see if this event is valid:', event)

  const delegation = event.tags.find(
    (tag) => tag.length === 4 && tag[0] === EventTags.Delegation
  )

  console.log(delegation)

  if (!delegation) {
    return false
  }

  // Validate rune
  const runifiedEvent = (
    converge(curry(mergeLeft), [
      omit(['tags']),
      pipe(
        prop('tags') as any,
        reduceBy<EventTags, string[]>(
          (acc, tag) => [...acc, tag[1]],
          [],
          nth(0) as any
        )
      ),
    ]) as any
  )(event)

  console.log('runifiedEvent:', runifiedEvent)
  console.log('So we are creating a RuneLike from:', delegation[2])

  let result: boolean
  try {
    ;[result] = RuneLike.from(delegation[2]).test(runifiedEvent)
    console.log('result huh:', result)
  } catch (error) {
    result = false
    console.log('result false:', result)
    console.warn(error)
  }

  if (!result) {
    console.log('no result byebye')
    return false
  }

  const serializedDelegationTag = `nostr:${delegation[0]}:${event.pubkey}:${delegation[2]}`

  console.log('serializedDelegationTag', serializedDelegationTag)

  const token = await secp256k1.utils.sha256(
    Buffer.from(serializedDelegationTag)
  )

  console.log('token:', token)

  // convert token to hex
  const tokenHex = Buffer.from(token).toString('hex')
  console.log('tokenHex is:', tokenHex)

  console.log(
    'NOW PASSING THESE THINGS TO SCHNORR VERIFIY',
    delegation[3],
    tokenHex,
    delegation[1]
  )

  //   try {
  const verified = await secp256k1.schnorr.verify(
    delegation[3],
    tokenHex,
    delegation[1]
  )
  //   console.log(verified)
  //   } catch (error) {
  // console.log('ERROR VERIFYING:', error)
  //   }

  return secp256k1.schnorr.verify(delegation[3], tokenHex, delegation[1])
}
