import React, { useState, useEffect, Fragment } from 'react'
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
  const [rate, setRate] = useState ({adult: 0, child:0, iva: 1})
  const [exchange, setExchange] = useState(0)


  const bkg = props.bkg
  bkg.date = (typeof bkg.calendarevent !== 'undefined') ? bkg.calendarevent.startdateatom : bkg.date


  useEffect( () => {

   const fetchExchange = async () => {
      setIsError(false)
      try {
        const exchangeapi = await axios.get('/api/priceplan/exchangeratesapiid')
        const apiid = exchangeapi.data

        const result = await axios.get('https://openexchangerates.org/api/latest.json?app_id=' + apiid)
        setExchange(result.data.rates.EUR)
      } catch (error) {
        setIsError(true)
      }
    }
    fetchExchange()
  }, [bkg.locator])

  const optionsDisplayDate = {
      weekday: 'long',
      day: 'numeric',
      month: 'long',
      year: 'numeric',
      timeZone: bkg.tz        
  }

  const optionsDisplayTz = {
      timeZoneName: 'long',
      timeZone: bkg.tz        
  }


  function showExchange() {
      const modal = {}
      modal.header = '<h4>Estimated price $ '+ (parseFloat(bkg.price)*1.02/exchange).toFixed(2) + '</h4>'
      modal.body = 'Our rates are in Euros, but some cards allow to pay in US Dollars. This amount is estimated based on today\'s exchange rate plus a 2% currency conversion fee'
      setModalContent(modal)
      setShowModal(true)
    }

  function updatePrice ( r = null) {
    if (r) {
      bkg.price = bkg.adult * r.adult + bkg.child * r.child
      bkg.iva = r.iva      
    } else {
      bkg.price = bkg.adult * rate.adult + bkg.child * rate.child
      bkg.iva = rate.iva      
    }
  }

  function handleAdultUpClick () {
    if (bkg.adult < 8) {
      bkg.adult++
      updatePrice()
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
      updatePrice()
      props.liftUp(bkg)
    }
  }

  function handleChildUpClick () {
    if (bkg.child < 4) {
      bkg.child++
      updatePrice()
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
      updatePrice()
      props.liftUp(bkg)
    }
  }

  function handleClassType (text) {
    bkg.type = text
    props.liftUp(bkg)
  }

  function handleUserTimeZone (tz) {
    bkg.tz = tz
    props.liftUp(bkg)
  }


  useEffect( () => {
    const fetchRate = async () => {
      setIsError(false)
      try {
        const result = await axios.get('/api/priceplan/get', {
              params: {
                source_id: 2,
                type: bkg.type
              }
            })
        setRate(result.data)
        updatePrice(result.data)
        props.liftUp(bkg)
      } catch (error) {
        setIsError(true)
      }
    }
    fetchRate()
  }, [bkg.type])

  return (
    <Fragment>
      {showModal && <MyModal text={modalContent} liftUp={() => setShowModal(false)} />}
      <table className='availability-table'>
        <tbody>
          <tr>
            <td className='font-weight-bold'>Date :</td>
            <td style={{ width: '75%' }}>
              <div>{new Intl.DateTimeFormat('en-GB', optionsDisplayDate).format(parseISO(bkg.date))}</div>
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
              { bkg.onlineclass > 0 && <UserTimeZone liftUp={handleUserTimeZone} timeZone={bkg.tz} />  }
            </td>
          </tr>
          <tr>
            <td className='font-weight-bold'>Price :</td>
              { (bkg.onlineclass == 0 || bkg.onlineclass > 0 && bkg.status !== 'PENDING') && <td>€ {(bkg.hide_price || !bkg.price) ? '--' : bkg.price}</td>}
              { bkg.onlineclass > 0 && bkg.status === 'PENDING' && <td>€ {(bkg.hide_price || !bkg.price) ? '--' :  <Fragment>{bkg.price} ($ {(parseFloat(bkg.price)*1.02/exchange).toFixed(2)} approx. <span className="small badge btn-primary"><a onClick={showExchange}>Why?</a></span>)</Fragment>}</td>}
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
  const optionsDisplayTime = {
      hour: 'numeric',
      minute: 'numeric',
      hour12: true,
      timeZone: bkg.tz    
  }
  const optionsDisplayDate = {
      weekday: 'long',
      day: 'numeric',
      month: 'long',
      year: 'numeric',
      timeZone: bkg.tz        
  }

  const optionsDisplayTz = {
      timeZoneName: 'long',
      timeZone: bkg.tz        
  }

  const tt = new Intl.DateTimeFormat('en-GB', optionsDisplayTz).format(start)
  const tzText = (bkg.onlineclass > 0) ? (' ' + tt.substr(tt.indexOf(' ') + 1)) : ''

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
              <td>{new Intl.DateTimeFormat('en-GB', optionsDisplayDate).format(parseISO(bkg.calendarevent.startdateatom))}</td>
            </tr>

            <tr>
              <td className='font-weight-bold'>Time :</td>
              <td>{new Intl.DateTimeFormat('en-GB', optionsDisplayTime).format(start) + ' - ' + 
                      new Intl.DateTimeFormat('en-GB', optionsDisplayTime).format(end) +
                      tzText }</td>
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
