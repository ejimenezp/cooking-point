import React, { useState, useEffect } from 'react'
import PropTypes from 'prop-types'
import { navigate } from '@reach/router'
import { useMediaQuery } from 'react-responsive'
import { InquiryDetails } from './InquiryDetails'
import { CustomerDetailsEdit } from './CustomerDetails'
import { MyModal } from './Components/Modal'
import { NavButtons } from './Components/NavButtons'

export default CustomerDetailsPage

CustomerDetailsPage.propTypes = {
  liftUp: PropTypes.func,
  bkg: PropTypes.object
}

function CustomerDetailsPage (props) {
  const [localbkg, setBkg] = useState(Object.assign({}, props.bkg))
  const [modalContent, setModalContent] = useState('')
  const [showModal, setShowModal] = useState(false)
  const isMobile = useMediaQuery({ maxWidth: 575 })

  useEffect(() => {
    if (isMobile) window.scrollTo(0, 0)
  }, [])

  function handleChange (bkg) {
    let b = Object.assign({}, localbkg)
    b = { ...b, ...bkg }
    b.store = true
    setBkg(b)
  }

  function valid () {
    const modal = {}
    modal.header = '<h4>Please check your data</h4>'
    modal.body = ''
    setShowModal(false)
    if (!localbkg.name) { modal.body += 'Enter a name<br/>' }
    if (!localbkg.email) { modal.body += 'Enter an e-mail <br/>' }
    let filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/
    if (localbkg.email && !filter.test(localbkg.email)) { modal.body += 'Enter a valid e-mail <br/>' }

    filter = /^[0-9 \(\)\-\+]+$/
    if (localbkg.phone && !filter.test(localbkg.phone)) { modal.body += 'Enter a valid phone number <br/>' }

    if (modal.body !== '') {
      setModalContent(modal)
      setShowModal(true)
      return false
    }
    return true
  }

  function handleButtonContinue () {
    if (valid()) {
      props.liftUp(localbkg)
      navigate('/booking/new/booking')
    }
  }

  function handleButtonSave () {
    if (valid()) {
      props.liftUp(localbkg)
      navigate('/booking/' + localbkg.locator)
    }
  }

  function handleButtonCancel () {
    navigate('/booking/' + localbkg.locator)
  }

  return (
    <div>
      <div className='row justify-content-center'>
        <div className='col-12'>
          <h1 className='mt-0'>Customer Details</h1>
          {localbkg.status === 'PENDING' && <p>You are about to book the following class:</p>}
          {(localbkg.status === 'CONFIRMED' || localbkg.status === 'PAY-ON-ARRIVAL') && <p>You can change any customer details.</p>}
        </div>
      </div>

      <InquiryDetails bkg={localbkg} />

      <CustomerDetailsEdit liftUp={handleChange} bkg={localbkg} />

      {showModal && <MyModal text={modalContent} liftUp={() => setShowModal(false)} />}

      <NavButtons>
        {!localbkg.locator && <div className='btn btn-secondary' onClick={() => navigate('/booking/new/availability')}>Change Class/Date</div>}{' '}
        {!localbkg.locator && <div className='btn btn-primary' onClick={handleButtonContinue}>Continue</div>}{' '}
        {localbkg.locator && <div className='btn btn-secondary' onClick={handleButtonCancel}>Cancel</div>}{' '}
        {localbkg.locator && <div className='btn btn-primary' onClick={handleButtonSave}>Save</div>}
      </NavButtons>
    </div>
  )
}
