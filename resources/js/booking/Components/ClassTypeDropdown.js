import React, { useState } from 'react'
import PropTypes from 'prop-types'
import onClickOutside from 'react-onclickoutside'

ClassTypeDropdown.propTypes = {
  liftUp: PropTypes.func,
  default: PropTypes.string
}

function ClassTypeDropdown (props) {
  ClassTypeDropdown.handleClickOutside = () => setIsOpen(false)
  const PAELLA = 0
  const TAPAS = 1
  const [isOpen, setIsOpen] = useState(false)
  const [selected, setSelected] = useState(props.default === 'TAPAS' ? TAPAS : PAELLA)

  const _class = [{ key: 'PAELLA', text: 'Paella Cooking Class' },
    { key: 'TAPAS', text: 'Tapas Cooking Class' }
  ]

  function handleDropdownClick (event) {
    setSelected(event)
    props.liftUp(_class[event].key)
    setIsOpen(false)
  }

  return (
    <div className='type-dropdown-input'>
      {!isOpen && <div className='type-dropdown-triangule' />}
      <div className='fake-input' onClick={() => setIsOpen(true)}>
        {_class[selected].text}
      </div>
      <ul id='myDropdown' className={isOpen ? 'type-dropdown-content d-block' : 'd-none'}>
        <li key='PAELLA' onClick={() => handleDropdownClick(PAELLA)}>{_class[PAELLA].text}</li>
        <li key='TAPAS' onClick={() => handleDropdownClick(TAPAS)}>{_class[TAPAS].text}</li>
      </ul>
    </div>
  )
}

const clickOutsideConfig = {
  handleClickOutside: () => ClassTypeDropdown.handleClickOutside
}

export default onClickOutside(ClassTypeDropdown, clickOutsideConfig)
