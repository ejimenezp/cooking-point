import ButtonGroup from 'react-bootstrap/ButtonGroup'

const MyButtonGroup = ({ children, ...props }) => {
  return (
    <>
    <div style={{ height: 100 }}></div>
    <ButtonGroup {...props} style={{height: 100 }} className="position-fixed bottom-0 start-50 translate-middle-x" size="lg" >
      {children}
    </ButtonGroup>
    </>
  )
}

export default MyButtonGroup
