import axios from 'axios'

function myDelete (...args) {
  return axios.delete(...args)
}

export default myDelete
