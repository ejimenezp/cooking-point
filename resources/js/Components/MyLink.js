import { Link } from 'react-router-dom'

const MyLink = ({ children, ...props }) => {
  return (
    <Link {...props} className="text-decoration-none text-reset" >
      {children}
    </Link>
  )
}

export default MyLink
