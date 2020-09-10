import React, { useRef, Fragment } from 'react'
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
        trigger={() => <div className='btn btn-primary'>Print Booking</div>}
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
      <Fragment>
        <div id='printer' className='d-print-block row' style={{ margin: '5rem' }}>
          <div className='col-md-10 d-print-block'>
            <div className='text-center'>
              <img alt='Cooking Point logo' src='/images/cookingpoint_logox75.png' />
              <div className='divider' />
              <h1>Booking Confirmation</h1>
            </div>

            <h2 className='mt-5'>Details</h2>

            <InquiryDetails bkg={this.bkg} />

            <CustomerDetails bkg={this.bkg} />

            { !!this.bkg.onlineclass && 
              <Fragment>
                <p className='mt-5'>Visit cookingpoint.es/booking/{this.bkg.locator} to:</p>
                <ul>
                  <li>Download your Virtual Class Handbook</li>
                  <li>Modify or cancel your booking</li>
                </ul>
              </Fragment>
            } 

            { !this.bkg.onlineclass && 
              <Fragment>
                <h2>Meeting Point</h2>
                <p>Cooking Point<br />
                  Calle de Moratin, 11 28014 Madrid<br />
                  tel. (+34) 910 115 154<br />
                  Metro Anton Martin (Line 1), exit Calle de Amor de Dios<br /><br />
                </p>
                <img className='rounded mx-auto d-block' alt='Cooking Point location' src='/images/plano-email.png' />
                <p className='mt-5'>Visit cookingpoint.es/booking/{this.bkg.locator} to modify or cancel your booking</p>
              </Fragment>
            }
           

          </div>
        </div>
      </Fragment>
    )
  }
}

Voucher.propTypes = {
  bkg: PropTypes.object
}
