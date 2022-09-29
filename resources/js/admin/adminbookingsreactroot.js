import React from 'react'
import { createRoot } from 'react-dom/client'
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom'

import { QueryClient, QueryClientProvider } from 'react-query'
import { format } from 'date-fns'
// import { ReactQueryDevtools } from 'react-query/devtools'
import 'bootstrap/dist/css/bootstrap.min.css'

import Layout from './Layout'
// import Bookings from './Bookings'
import ShopDatepicker from './ShopDatepicker'

import Shop from './Shop'
import ShopIndex from './ShopIndex'
import TicketDetails from '../Components/Shop/TicketDetails'
import TicketNew from '../Components/Shop/TicketNew'
import TicketDelete from '../Components/Shop/TicketDelete'

import Wallet from './Wallet'
import WalletIndex from './WalletIndex'
import WalletItemDetails from '../Components/Wallet/WalletItemDetails'
import WalletItemNew from '../Components/Wallet/WalletItemNew'
import WalletItemEdit from '../Components/Wallet/WalletItemEdit'
import WalletItemDelete from '../Components/Wallet/WalletItemDelete'

import NoPage from './NoPage'

// import './index.scss'

const queryClient = new QueryClient()

export default function AdminBookingsReactRoot () {
  return (
    <QueryClientProvider client={queryClient}>
{/*      <ReactQueryDevtools initialIsOpen={false} />
*/}      <BrowserRouter forceRefresh>
        <Routes>
          <Route path="/admin" element={<Layout />}>
            {/*<Route index element={<Bookings />} />*/}
            {/*<Route path="bookings" element={<Bookings />} />*/}
            <Route path="shop" element={<Navigate to={format(new Date(), 'yyyy-MM-dd')} replace />} />
            <Route path="shop/:workingDate" element={<Shop />} >
              <Route index element={<ShopIndex />} />
              <Route path="new" element={<TicketNew />} />
              <Route path="datepicker" element={<ShopDatepicker />} />
              <Route path="ticket/:ticketId" element={<TicketDetails />} />
              <Route path="ticket/:ticketId/delete" element={<TicketDelete />} />
            </Route>
            <Route path="wallet" element={<Wallet />} >
              <Route index element={<WalletIndex />} />
              <Route path="new" element={<WalletItemNew />} />
              <Route path=":id" element={<WalletItemDetails />} />
              <Route path=":id/edit" element={<WalletItemEdit />} />
              <Route path=":id/delete" element={<WalletItemDelete />} />
            </Route>
            <Route path="*" element={<NoPage />} />
          </Route>
        </Routes>
      </BrowserRouter>
    </QueryClientProvider>
  )
}

const root = createRoot(document.getElementById('AdminBookingsReactRoot'))
root.render(<AdminBookingsReactRoot />)
