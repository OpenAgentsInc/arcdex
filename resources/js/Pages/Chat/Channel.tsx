import * as React from 'react'
import { InputBar } from '../../Components/InputBar'
import { Message } from '../../Components/Message'

const Channel = () => {
  return (
    <div className="flex flex-col h-full w-full dark:bg-gray-800 overflow-hidden items-stretch flex-1">
      <div
        id="chatbox-container"
        className="h-full w-full grow nice-scrollbar overflow-y-scroll"
      >
        <div className="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
          {/* Replace with your content */}
          <div className="py-4">
            {messages.map((message) => (
              <Message message={message} key={message.id} />
            ))}
          </div>
        </div>
      </div>
      <InputBar />
    </div>
  )
}

export default Channel

const messages = [
  {
    id: '1',
    user: 'Alice',
    text: 'Hello',
    time: '08:42PM', //'2021-03-10T15:34:00.000000Z',
    unread: false,
  },
  {
    id: '2',
    user: 'Bob',
    text: 'Hi, Alice!',
    time: '08:43PM', //'2021-03-10T15:34:30.000000Z',
    unread: true,
  },
  {
    id: '3',
    user: 'Carol',
    text: 'Hey everyone!',
    time: '08:44PM', //'2021-03-10T15:35:00.000000Z',
    unread: true,
  },
  {
    id: '4',
    user: 'Dave',
    text: 'Whats up?',
    time: '08:45PM', //'2021-03-10T15:35:30.000000Z',
    unread: false,
  },
  {
    id: '5',
    user: 'Eve',
    text: 'Not much, you?',
    time: '08:46PM', //'2021-03-10T15:36:00.000000Z',
    unread: false,
  },
  {
    id: '6',
    user: 'Frank',
    text: 'Just hanging out',
    time: '08:47PM', //'2021-03-10T15:36:30.000000Z',
    unread: true,
  },
  {
    id: '7',
    user: 'George',
    text: 'Cool',
    time: '08:48PM', //'2021-03-10T15:37:00.000000Z',
    unread: false,
  },
  {
    id: '8',
    user: 'Hannah',
    text: 'What have you been up to?',
    time: '08:49PM', //'2021-03-10T15:37:30.000000Z',
    unread: true,
  },
  {
    id: '9',
    user: 'Ivan',
    text: 'Just catching up on some work',
    time: '08:50PM', //'2021-03-10T15:38:00.000000Z',
    unread: false,
  },
  {
    id: '10',
    user: 'Julie',
    text: 'Sounds fun!',
    time: '08:51PM', //'2021-03-10T15:38:30.000000Z',
    unread: false,
  },
  {
    id: '11',
    user: 'Kevin',
    text: 'Yeah, not too bad',
    time: '08:52PM', //'2021-03-10T15:39:00.000000Z',
    unread: true,
  },
  {
    id: '12',
    user: 'Liz',
    text: 'How about you?',
    time: '08:53PM', //'2021-03-10T15:39:30.000000Z',
    unread: true,
  },
  {
    id: '13',
    user: 'Mark',
    text: 'Just finished up a project',
    time: '08:54PM', //'2021-03-10T15:40:00.000000Z',
    unread: false,
  },
  {
    id: '14',
    user: 'Nina',
    text: 'Congrats!',
    time: '08:55PM', //'2021-03-10T15:40:30.000000Z',
    unread: false,
  },
]