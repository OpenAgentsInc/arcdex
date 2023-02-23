import * as React from 'react'
import * as Popover from '@radix-ui/react-popover'

export const NostrConnectExplainer = () => (
  <Popover.Root>
    <Popover.Trigger className="text-indigo-300/75 italic text-sm py-1">
      What is Nostr Connect?
    </Popover.Trigger>
    <Popover.Portal>
      <Popover.Content className="PopoverContent" sideOffset={5}>
        <p className="mb-4">
          Nostr Connect allow apps to connect with remote signing devices, so
          you don't need to reveal your private key.
        </p>

        <a
          href="https://github.com/nostr-protocol/nips/pull/153"
          target="_blank"
        >
          <p className="text-indigo-700 underline">Read more on GitHub.</p>
        </a>

        <Popover.Arrow className="PopoverArrow" />
      </Popover.Content>
    </Popover.Portal>
  </Popover.Root>
)
