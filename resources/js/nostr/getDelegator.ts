import { Event } from 'nostr-tools'
import { sha256 } from '@noble/hashes/sha256'
import { utf8Encoder } from 'nostr-tools/utils'
import * as secp256k1 from '@noble/secp256k1'

export function getDelegator(event: Event): string | null {
  // find delegation tag
  let tag = event.tags.find((tag) => tag[0] === 'delegation' && tag.length >= 4)
  if (!tag) return null

  let pubkey = tag[1]

  console.log('The pubkey of the DELEGATOR (Signer app):', pubkey)

  let cond = tag[2]
  let sig = tag[3]

  // check conditions
  let conditions = cond.split('&')
  for (let i = 0; i < conditions.length; i++) {
    let [key, operator, value] = conditions[i].split(/\b/)

    // the supported conditions are just 'kind' and 'created_at' for now
    if (key === 'kind' && operator === '=' && event.kind === parseInt(value))
      continue
    else if (
      key === 'created_at' &&
      operator === '<' &&
      event.created_at < parseInt(value)
    )
      continue
    else if (
      key === 'created_at' &&
      operator === '>' &&
      event.created_at > parseInt(value)
    )
      continue
    else return null // invalid condition
  }

  console.log(
    `gonna encode this ----- nostr:delegation:${event.pubkey}:${cond}`
  )

  // check signature
  let sighash = sha256(
    utf8Encoder.encode(`nostr:delegation:${event.pubkey}:${cond}`)
  )
  console.log('HERE WITH SIGHASH: ', sighash)
  if (!secp256k1.schnorr.verifySync(sig, sighash, pubkey)) return null

  return pubkey
}
