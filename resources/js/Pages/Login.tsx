import * as React from 'react'
import { LoginScreen } from '../login/LoginScreen'

export default function LoginPage() {
  return <LoginScreen />
  //   return <h1 className="text-3xl text-white text-center">Login Page</h1>
}

LoginPage.layout = (page: React.ReactNode) => {
  return <div className="h-full">{page}</div>
}
//   return (
//     <div className="font-sans text-white h-full w-full bg-gray-900 flex flex-col justify-center items-center space-y-10">
//       {/* <img
//         className="mb-8"
//         src="/img/logo.png"
//         alt="logo"
//         style={{ height: 150 }}
//       /> */}
//       {page}
//     </div>
//   )
// }
