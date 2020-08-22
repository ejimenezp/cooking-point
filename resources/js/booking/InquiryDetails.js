import React, { useState, Fragment } from 'react'
import PropTypes from 'prop-types'
import { format, add, parseISO } from 'date-fns'
import { useMediaQuery } from 'react-responsive'
import { ClassTypeDropdown } from './Components/ClassTypeDropdown'
import { UserTimeZone } from './Components/UserTimeZone'
import { MyModal } from './Components/Modal'
import { BkgStatus } from './Components/BkgStatus'

const axios = require('axios').default

export { InquiryDetailsEdit, InquiryDetails }

InquiryDetailsEdit.propTypes = {
  liftUp: PropTypes.func,
  bkg: PropTypes.object
}

InquiryDetails.propTypes = {
  bkg: PropTypes.object,
  hide_price: PropTypes.bool,
  price: PropTypes.number

}

function InquiryDetailsEdit (props) {
  const leftStyle = { width: '20%', textAlign: 'left' }
  const centerStyle = { width: '20%', textAlign: 'center' }
  const rightStyle = { width: '20%', textAlign: 'right' }
  const [modalContent, setModalContent] = useState('')
  const [showModal, setShowModal] = useState(false)
  const [isError, setIsError] = useState(false)


  const bkg = props.bkg
  const isOnline = bkg.type.includes('ONLINE')

  function updatePrice () {
    setIsError(false)
    axios.get('/api/booking/price', {
        params: {
          adult: bkg.adult,
          child: bkg.child,
          source_id: 2,
          type: bkg.type
        }
      })
      .then((result) => {
        bkg.price = result.data.price
        bkg.iva = result.data.iva
        props.liftUp(bkg)
      })
      .catch(() => setIsError(true))
  }

  function handleAdultUpClick () {
    if (bkg.adult < 8) {
      bkg.adult++
      updatePrice()
    } else {
      const modal = {}
      modal.header = '<h4>Warning</h4>'
      modal.body = 'To book 9+ people, please contact us'
      setModalContent(modal)
      setShowModal(true)
    }
  }

  function handleAdultDownClick () {
    if (bkg.adult > 0) {
      bkg.adult--
      updatePrice()
    }
  }

  function handleChildUpClick () {
    if (bkg.child < 4) {
      bkg.child++
      updatePrice()
    } else {
      const modal = {}
      modal.header = '<h4>Warning</h4>'
      modal.body = 'To book 5+ children, please contact us'
      setModalContent(modal)
      setShowModal(true)
    }
  }

  function handleChildDownClick () {
    if (bkg.child > 0) {
      bkg.child--
      updatePrice()
    }
  }

  function handleClassType (text) {
    bkg.type = text
    updatePrice()
  }

  function handleUserTimeZone (tz) {
    bkg.tz = tz
    props.liftUp(bkg)
  }

  return (
    <Fragment>
      {showModal && <MyModal text={modalContent} liftUp={() => setShowModal(false)} />}
      <table className='availability-table'>
        <tbody>
          <tr>
            <td className='font-weight-bold'>Date :</td>
            <td style={{ width: '75%' }}>
              <div>{format(parseISO(bkg.date), 'cccc, d LLLL yyyy')}</div>
            </td>
          </tr>
          <tr>
            <td className='font-weight-bold'>Adults :</td>
            <td>
              <table>
                <tbody>
                  <tr>
                    {bkg.status === 'PENDING' &&
                      <Fragment>
                        <td style={leftStyle} />
                        <td style={leftStyle}><div id='adult-down' onClick={handleAdultDownClick} className='icon'><img src='/images/icons/minus.png' /></div></td>
                        <td style={centerStyle}><div className='fake-input text-center'>{bkg.adult}</div></td>
                        <td style={rightStyle}><div id='adult-up' onClick={handleAdultUpClick} className='icon'><img src='/images/icons/add.png' /></div></td>
                        <td style={rightStyle} />
                      </Fragment>}
                    {bkg.status !== 'PENDING' &&
                      <td>{bkg.adult}</td>}
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td className='font-weight-bold'>Children :</td>
            <td>
              <table>
                <tbody>
                  <tr>
                    {bkg.status === 'PENDING' &&
                      <Fragment>
                        <td style={leftStyle} />
                        <td style={leftStyle}><div id='child-down' onClick={handleChildDownClick} className='icon'><img src='/images/icons/minus.png' /></div></td>
                        <td style={centerStyle}><div className='fake-input text-center'>{bkg.child}</div></td>
                        <td style={rightStyle}><div id='child-up' onClick={handleChildUpClick} className='icon'><img src='/images/icons/add.png' /></div></td>
                        <td style={rightStyle} />
                      </Fragment>}
                    {bkg.status !== 'PENDING' &&
                      <td>{bkg.child}</td>}
                  </tr>
                </tbody>

              </table>
            </td>
          </tr>
          <tr>
            <td className='font-weight-bold'>Class :</td>
            <td>
              <ClassTypeDropdown liftUp={handleClassType} default={bkg.type} userTimeZone={bkg.tz} onlineclass={bkg.onlineclass}/>
            </td>
          </tr>
          { isOnline && <tr><td></td><td><UserTimeZone liftUp={handleUserTimeZone} timeZone={bkg.tz} /> </td></tr> }
          <tr>
            <td className='font-weight-bold'>Price :</td>
            <td>{(bkg.hide_price || !bkg.price) ? '--' : '€ '+ bkg.price}</td>
          </tr>
          <tr style={{ height: '2rem' }} />
        </tbody>
      </table>
    </Fragment>
  )
}



function InquiryDetails (props) {
  const bkg = props.bkg
  const isMobile = useMediaQuery({ maxWidth: 575 })
  const start = new Date(bkg.calendarevent.startdateatom)
  const end = add(start, { hours: bkg.calendarevent.duration.split(':')[0], minutes: bkg.calendarevent.duration.split(':')[1] })

  console.log(start)
  console.log(end)
  return (
    <div className='row'>
      <div className='col-lg-5'>
        <table className='voucher-table'>
          <tbody>
            <tr>
              <td className='font-weight-bold'>Class :</td>
              <td>{bkg.calendarevent.short_description}</td>
            </tr>
            <tr>
              <td className='font-weight-bold'>Date :</td>
              <td>{format(parseISO(bkg.calendarevent.startdateatom), 'cccc, d LLLL yyyy')}</td>
            </tr>

            <tr>
              <td className='font-weight-bold'>Time :</td>
              <td>{format(start, 'h:mm a') + ' - ' + format(end, 'h:mm a')}</td>
            </tr>
            <tr>
              <td className='font-weight-bold'>{isMobile ? 'Bkg # :' : 'Booking # :'}</td>
              <td>{bkg.locator || '--'}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div className='col-lg-5'>
        <table className='voucher-table'>
          <tbody>
            <tr>
              <td className='font-weight-bold'>Adults :</td>
              <td>{bkg.adult}</td>
            </tr>
            <tr>
              <td className='font-weight-bold'>{isMobile ? 'Children:' : 'Children :'}</td>
              <td>{bkg.child}</td>
            </tr>
            <tr>
              <td className='font-weight-bold'>Price :</td>
              <td>€ {bkg.hide_price ? '--' : bkg.price}</td>
            </tr>
            <tr>
              <td className='font-weight-bold'>Status :</td>
              <td><BkgStatus status={bkg.status} /></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  )
}
