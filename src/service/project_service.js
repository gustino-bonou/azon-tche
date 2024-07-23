import Api from '@/apis/Api'
import { ref } from 'vue'

const success = ref(false)
const errors = ref({})
const projects = ref({})
const message = ref("")



export default function projectService() {

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

  const storeProject = async (data) => {
    await Api.post('/project/store', data)
      .then((response) => {
        if (response.status === 200) {
          success.value = true
        }
      })
      .catch((error) => {
        console.log("error", error)
        success.value = false
        if (error.response.status === 422) {
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
      }
    } else {
     // errorList.push("Une erreur s'est produite");
        }
      })
  }

  const updateProject = async (data, id) => {
    await Api.put(`/project/update/${id}`, data)
      .then((response) => {
        if (response.status === 200) {
          success.value = true
        }
      })
      .catch((error) => {
        console.log("error", error)
        success.value = false
        if (error.response.status === 422) {
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
      }
    } else {
     // errorList.push("Une erreur s'est produite");
        }
      })
  }

  const getProjects = async (data) => {
    await Api.get('/project', data)
      .then((response) => {
        if (response.status === 200) {
          projects.value = response.data.data
          success.value = true
        }
      })
      .catch((error) => {
        success.value = false
        message.value = error.response?.data?.message ?? "Une erreur s'est produite"        
      })
  }

  return {
      storeProject,
    getProjects,
      updateProject,
    message,
      projects,
      errors,
    success,
  }
}
