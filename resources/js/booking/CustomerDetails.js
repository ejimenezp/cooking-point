import React from 'react'
import PropTypes from 'prop-types'
import { useMediaQuery } from 'react-responsive'

CustomerDetailsEdit.propTypes = {
  liftUp: PropTypes.func,
  bkg: PropTypes.object
}

CustomerDetails.propTypes = {
  bkg: PropTypes.object
}

function CustomerDetailsEdit (props) {
  const bkg = props.bkg
  const isMobile = useMediaQuery({ maxWidth: 768 })

  function handleChange (event) {
    bkg[event.target.name] = event.target.value
    props.liftUp(bkg)
  }

  return (
    <div>
      <div className='row justify-content-center'>
        <div className='col-12'>
          <br />
          <p>Please, enter your contact info :   <small>(<span style={{ color: 'red' }}>*</span> = required)</small></p>
        </div>
      </div>

      {!isMobile &&
        <div className='row justify-content-center'>
          <div className='col-lg-5'>
            <table className='availability-table'>
              <tbody>
                <tr>
                  <td className='font-weight-bold'>
                    Name <span className='text-danger'>*</span> :
                  </td>
                  <td>
                    <input name='name' type='text' value={bkg.name || ''} onChange={handleChange} />
                  </td>
                </tr>
                <tr>
                  <td className='font-weight-bold'>
                    E-mail <span className='text-danger'>*</span> :
                  </td>
                  <td>
                    <input name='email' type='email' value={bkg.email || ''} onChange={handleChange} />
                  </td>
                </tr>
                <tr>
                  <td className='font-weight-bold'>
                    Phone :
                  </td>
                  <td>
                    <input name='phone' type='text' value={bkg.phone || ''} onChange={handleChange} />
                  </td>
                </tr>
              </tbody>
            </table>
            <p />
          </div>

          <div className='col-lg-7'>
            <table className='availability-table'>
              <tbody>
                <tr>
                  <td className='font-weight-bold' style={{ width: '30%' }}>
                    Food Restrictions :
                  </td>
                  <td>
                    <textarea name='food_requirements' value={bkg.food_requirements || ''} onChange={handleChange} />
                  </td>
                </tr>
                <tr>
                  <td className='font-weight-bold'>
                    Comments :
                  </td>
                  <td>
                    <textarea name='comments' value={bkg.comments || ''} onChange={handleChange} />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>}

      {isMobile &&
        <div className='row justify-content-center'>
          <div className='col-12'>
            <p className='font-weight-bold mb-0'>Name <span className='text-danger'>*</span> :</p>
            <input name='name' type='text' value={bkg.name || ''} onChange={handleChange} />
            <p className='font-weight-bold mb-0 mt-3'>E-mail <span className='text-danger'>*</span> :</p>
            <input name='email' type='email' value={bkg.email || ''} onChange={handleChange} />
            <p className='font-weight-bold mb-0 mt-3'>Phone :</p>
            <input name='phone' type='text' value={bkg.phone || ''} onChange={handleChange} />
            <p className='font-weight-bold mb-0 mt-3'>Food Restrictions :</p>
            <textarea rows='3' name='food_requirements' value={bkg.food_requirements || ''} onChange={handleChange} />
            <p className='font-weight-bold mb-0 mt-3'>Comments :</p>
            <textarea rows='3' name='comments' value={bkg.comments || ''} onChange={handleChange} />
          </div>
        </div>}
    </div>
  )
}

function CustomerDetails (props) {
  const bkg = props.bkg
  const isMobile = useMediaQuery({ maxWidth: 768 })

  return (
    <div>
      <div className='row justify-content-center'>
        <div className='col-12'>
          <br />
          <p>Customer Details :</p>
        </div>
      </div>

      <div className='row justify-content-center'>
        <div className='col-lg-5'>
          <table className='voucher-table'>
            <tbody>
              <tr>
                <td className='font-weight-bold'>
                  Name :
                </td>
                <td>
                  {bkg.name}
                </td>
              </tr>
              <tr>
                <td className='font-weight-bold'>
                  E-mail :
                </td>
                <td>
                  {bkg.email}
                </td>
              </tr>
              <tr>
                <td className='font-weight-bold'>
                  Phone :
                </td>
                <td>
                  {bkg.phone ? bkg.phone : '--'}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        {!isMobile &&
          <div className='col-md-7'>
            <table className='voucher-table'>
              <tbody>
                <tr>
                  <td className='font-weight-bold'>
                    Food Restrictions :
                  </td>
                  <td>
                    {bkg.food_requirements ? bkg.food_requirements : '--'}
                  </td>
                </tr>
                <tr>
                  <td className='font-weight-bold'>
                    Comments :
                  </td>
                  <td>
                    {bkg.comments.length ? bkg.comments : '--'}
                  </td>
                </tr>
                <tr style={{ height: '2rem' }} />
              </tbody>
            </table>
            <p />
          </div>}

        {isMobile &&
          <div className='col-12'>
            <p className='font-weight-bold mb-0 d-inline'>Food Restrictions :</p>
            {!bkg.food_requirements && <p className='mb-0 d-inline-block'>&nbsp;--</p>}
            {!bkg.food_requirements && <p className='m-0' />}
            {bkg.food_requirements && <p className='mb-0'>{bkg.food_requirements}</p>}
            <p className='font-weight-bold mb-0 d-inline'>Comments :</p>
            {!bkg.comments && <p className='d-inline-block'>&nbsp;--</p>}
            {bkg.comments && <p>{bkg.comments}</p>}
          </div>}
      </div>
    </div>
  )
}

export { CustomerDetails, CustomerDetailsEdit }
