import React, { useEffect, Fragment } from 'react'
import PropTypes from 'prop-types'
import { useMediaQuery } from 'react-responsive'

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
  })
  const mobileChildren = [...listButtons]

  useEffect(() => {
    document.getElementById(props.id).previousElementSibling.style.marginBottom = '5rem'
  }, [])

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
        <div id={props.id} className='adminnav-buttons-mobile bottom-button'>
          <ul>
            {mobileChildren}
          </ul>
        </div>}
    </Fragment>
  )
}
