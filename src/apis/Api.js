import axios from "axios"

let Api = axios.create({
  baseURL: "http://127.0.0.1:8000/api"
})


Api.interceptors.request.use(config => {
  config.headers.common = {
    Authorization: `Bearer ${localStorage.getItem('tokenTask')}`,
    "Content-Type": "application/json",
    Accept: "application/json",
    
  }
  
  return config
})

Api.defaults.withCredentials = true
Api.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('tokenTask')
export default Api