import React, { useState, useEffect, Fragment } from 'react'
import PropTypes from 'prop-types'
import { useMediaQuery } from 'react-responsive'
import Modal from 'react-bootstrap/Modal'

export { NavButtons }

NavButtons.propTypes = {
  children: PropTypes.array,
  id: PropTypes.string
}

function NavButtons (props) {
  const children = props.children
  const isMobile = useMediaQuery({ maxWidth: 575 })
  const listButtons = children.map((item) => {
    return item.type === 'div' ? <li key={item.props.children}>{item}</li> : null
  }).filter(x => x)
  const [bottomBtn, setBottomBtn] = useState()
  const [modalBtn, setModalBtn] = useState()
  const [showModal, setShowModal] = useState(false)

  useEffect(() => {
    document.getElementById(props.id).previousElementSibling.style.marginBottom = '5rem'
    if (listButtons.length <= 3) {
      setBottomBtn(listButtons)
    } else {
      const modalSide = listButtons.slice(2)
      const bottomSide = listButtons.slice(0, 2)
      bottomSide.push(<li key={443}><div className='btn btn-secondary' onClick={() => setShowModal(true)}>...</div></li>)
      setBottomBtn(bottomSide)
      setModalBtn(modalSide)
    }
  }, [])

  return (
    <Fragment>
      <Modal show={showModal} dialogClassName='navbuttons-modal' size='sm' onHide={() => setShowModal(false)} animation={false}>
        <div className='text-center mb-1'>
          {modalBtn}
        </div>
      </Modal>
      {!isMobile &&
        <div className='row justify-content-center'>
          <div className='col-12'>
            <div className='text-center'>
              {children}
            </div>
          </div>
        </div>}
      {isMobile &&
        <div id={props.id} className='adminnav-buttons-mobile bottom-button'>
          <ul>
            {bottomBtn}
          </ul>
        </div>}
    </Fragment>
  )
}
