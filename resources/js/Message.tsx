export const Message = ({ message }) => {
  return (
    <div className="flex flex-col bg-gray-900 my-4 py-2 px-3 rounded-lg">
      <p className="text-teal-500">{message.user}</p>
      <p className="text-gray-500">{message.content}</p>
    </div>
  )
}
