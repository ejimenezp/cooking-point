import React, { Component } from 'react'

function Fila (props) {
  const valorescomoarray = Object.values(props.valores)

  return (
    valorescomoarray.map((celda) => <td key={celda.toString()}>{celda.toString()}</td>)
  )
}

class Tabla extends Component {
  constructor (props) {
    super(props)
  }

  render () {
    return (
      <div>
        <p>La tabla</p>
        {/* <p>{JSON.stringify(this.props.filas)}</p> */}
        <table className='table'>
          <tbody>
            {this.props.filas.map((fila) =>
              <tr key={Object.values(fila)[0].toString()}>
                <Fila valores={fila} />
              </tr>)}
          </tbody>
        </table>
      </div>
    )
  }
}

export default Tabla
