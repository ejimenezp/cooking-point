import React, { useState, Fragment } from 'react'
import PropTypes from 'prop-types'
import { format, add, parseISO } from 'date-fns'
import { useMediaQuery } from 'react-responsive'
import ClassTypeDropdown from './Components/ClassTypeDropdown'
import { MyModal } from './Components/Modal'
import { BkgStatus } from './Components/BkgStatus'

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

  const bkg = props.bkg

  function handleAdultUpClick () {
    if (bkg.adult < 8) {
      bkg.adult++
      bkg.price = 70 * bkg.adult + 35 * bkg.child
      props.liftUp(bkg)
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
      bkg.price = 70 * bkg.adult + 35 * bkg.child
      props.liftUp(bkg)
    }
  }

  function handleChildUpClick () {
    if (bkg.child < 4) {
      bkg.child++
      bkg.price = 70 * bkg.adult + 35 * bkg.child
      props.liftUp(bkg)
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
      bkg.price = 70 * bkg.adult + 35 * bkg.child
      props.liftUp(bkg)
    }
  }

  function handleClassType (text) {
    bkg.type = text
    // setCal(bkg.date + bkg.type)
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
              <ClassTypeDropdown liftUp={handleClassType} default={bkg.type} />
            </td>
          </tr>
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
  const start = parseISO('1970-01-01 ' + bkg.calendarevent.time)
  const end = add(start, { hours: bkg.calendarevent.duration.split(':')[0], minutes: bkg.calendarevent.duration.split(':')[1] })

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
              <td>{format(parseISO(bkg.date), 'cccc, d LLLL yyyy')}</td>
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
