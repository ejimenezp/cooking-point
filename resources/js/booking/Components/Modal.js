import React, { useState } from 'react'
import PropTypes from 'prop-types'
import { Modal, Button } from 'react-bootstrap'

export { MyModal }

MyModal.propTypes = {
  text: PropTypes.object,
  liftUp: PropTypes.func
}

function MyModal (props) {
  const [show, setShow] = useState(true)

  function handleClose () {
    setShow(false)
    props.liftUp()
  }

  return (
    <Modal show={show} onHide={handleClose} animation={false} centered>
      <Modal.Body dangerouslySetInnerHTML={{ __html: props.text.header + props.text.body }} />
      <Modal.Footer>
        <Button variant='primary' onClick={handleClose}>Close</Button>
      </Modal.Footer>
    </Modal>
  )
}
