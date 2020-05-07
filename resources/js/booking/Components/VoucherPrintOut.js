import React, { useRef } from 'react'
import ReactToPrint from 'react-to-print'
import { InquiryDetails } from '../InquiryDetails'
import { CustomerDetails } from '../CustomerDetails'

import PropTypes from 'prop-types'

export { VoucherPrintOut }

VoucherPrintOut.propTypes = {
  bkg: PropTypes.object
}

function VoucherPrintOut (props) {
  const componentRef = useRef()
  return (
    <span>
      <ReactToPrint
        trigger={() => <div className='btn btn-primary'>Print Voucher</div>}
        content={() => componentRef.current}
      />
      <div style={{ display: 'none' }}>
        <Voucher ref={componentRef} bkg={props.bkg} />
      </div>
    </span>
  )
}

class Voucher extends React.Component {
  constructor (props) {
    super(props)
    this.bkg = this.props.bkg
  }

  render () {
    return (
      <div>
        <div id='printer' className='d-print-block row' style={{ margin: '5rem' }}>
          <div className='col-md-10 d-print-block'>
            <div className='text-center'>
              <img alt='Cooking Point logo' src='/images/cookingpoint_logox75.png' />
              <div className='divider' />
              <h1>Cooking Point Voucher</h1>
            </div>

            <h2 className='mt-5'>Booking Details</h2>

            <InquiryDetails bkg={this.bkg} />

            <CustomerDetails bkg={this.bkg} />

            <h2>Meeting Point</h2>
            <p>Cooking Point<br />
              Calle de Moratin, 11 28014 Madrid<br />
              tel. (+34) 910 115 154<br />
              Metro Anton Martin (Line 1), exit Calle de Amor de Dios<br /><br />
            </p>
            <img className='rounded mx-auto d-block' alt='Cooking Point location' src='/images/plano-email.png' />
            <p className='mt-5'>Access/Edit this booking online at: cookingpoint.es/booking/{this.bkg.locator}</p>
          </div>
        </div>
      </div>
    )
  }
}

Voucher.propTypes = {
  bkg: PropTypes.object
}
