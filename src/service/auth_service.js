import Api from '@/apis/Api'
import { ref } from 'vue'

const success = ref(false)
const errors = ref({})
const currentUser = ref({})
const message = ref("")



export default function useAuthService() {

/*   const getRolesList = async (data) => {
    await Api.get('/roles', data)
      .then((response) => {
        if (response.status === 200) {
          success.value = true
          roles.value = response.data.data
        }
      })
      .catch((error) => {
        console.log(error)
      })
  }
 */

  const login = async (data) => {
    await Api.post('/auth/login', data)
      .then((response) => {
        if (response.status === 200) {
          const data = response.data.data
          localStorage.setItem('tokenTask', data.token)
          localStorage.setItem('userArrete',  data.user)
          success.value = true
        }
      })
      .catch((error) => {
        success.value = false
        if (error.response.status === 422) {
                  console.log('data are', error.response.data)

          let newError = {}
          if (error.response?.data?.data) {
        const dataErrors = error.response.data.data;
        Object.keys(dataErrors).forEach(key => {
          const errorMessages = dataErrors[key];
          newError[`${key}`] = errorMessages[0]
        });

        errors.value = newError
      } else if (error.response?.data?.message) {
        errors.value = { general: error.response?.data?.message }
        console.log('in error', errors.value)
      }
    } else {
     // errorList.push("Une erreur s'est produite");
        }
      })
  }
    const getAuthUser = async () => {
    await Api.get('/auth/profile')
      .then((response) => {
        if (response.status === 200) {
          currentUser.value = response.data.data
          success.value = true
        }
      })
      .catch((error) => {
        success.value = false
        console.log(error)
      })
  }
  const register = async (data) => {
    await Api.post('/auth/register', data)
      .then((response) => {
        if (response.status === 200) {
          const data = response.data.data
          localStorage.setItem('tokenTask', data.token)
          localStorage.setItem('userArrete',  data.user)
          success.value = true
        }
      })
      .catch((error) => {
        success.value = false
        if (error.response.status === 422) {
      let newError = {}
      if(error.response?.data?.data){
        const dataErrors = error.response.data.data;
        Object.keys(dataErrors).forEach(key => {
          const errorMessages = dataErrors[key];
          newError[`${key}`] = errorMessages[0]
        });

        errors.value = newError
      } else {
        message.value = error.response?.data?.message ?? "Une erreur s'est produite"
      }
    } else {
message.value = error.response?.data?.message ?? "Une erreur s'est produite"        }
        

      })
  }

  return {
      login,
      register,
    currentUser,
      message,
    errors,
      getAuthUser,
    success,
  }
}
