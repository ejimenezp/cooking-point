import axios from 'axios'

function myPost (...args) {
  return axios.post(...args)
}

export default myPost
