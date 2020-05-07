import React, { Fragment } from 'react'
import PropTypes from 'prop-types'
import { useMediaQuery } from 'react-responsive'

export { NavButtons }

NavButtons.propTypes = {
  children: PropTypes.array
}

function NavButtons (props) {
  const children = props.children
  const isMobile = useMediaQuery({ maxWidth: 575 })
  const listButtons = children.map((item) => {
    return item.type === 'div' ? <li key={item.props.children}>{item}</li> : null
  })
  const reversedChildren = [...listButtons].reverse()

  return (
    <Fragment>
      {!isMobile &&
        <div className='row justify-content-center'>
          <div className='col-12'>
            <div className='text-center'>
              {children}
            </div>
          </div>
        </div>}
      {isMobile &&
        <div className='row nav-buttons-mobile'>
          <div className='col-12'>
            <ul>
              {reversedChildren}
            </ul>
          </div>
        </div>}
    </Fragment>
  )
}
