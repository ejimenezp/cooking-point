import Button from 'react-bootstrap/Button'

const MyButton = ({ children, ...props }) => {
  return (
    <Button {...props} className="mx-1 w-50 h-100 rounded overflow-hidden"  >
      {children}
    </Button>
  )
}

export default MyButton
