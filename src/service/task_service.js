import Api from '@/apis/Api'
import { ref } from 'vue'

const success = ref(false)
const message = ref({})
const tasks = ref([])
const projects = ref([])
const errors = ref([])
const defaultProject = ref([])
const taskPaginationData = ref([])
const users = ref([])
const task = ref({})




export default function taskService() {

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

  const homeData = async (data) => {
    await Api.get('/task', data)
      .then((response) => {
        if (response.status === 200) {
            projects.value = response.data?.projects?.data ?? []
            taskPaginationData.value = response.data?.tasks ?? []
            tasks.value = response.data?.tasks?.data ?? []
            defaultProject.value = response.data?.defualt_project ?? {}
            success.value = true
            console.log( tasks.value)
        }
      })
        .catch((error) => {
        success.value = false
            message.value = error.response?.data?.message ?? "Une erreur s'est produite"
            console.log(message.value)
      })
    }

    const getProjectTasks = async (data) => {
    await Api.post('/task/project_tasks', data)
      .then((response) => {
          if (response.status === 200) {
            console.log( response)
              tasks.value = response.data?.data ?? []
              console.log('tasks', tasks.value)
            taskPaginationData.value = response.data ?? []
            success.value = true
        }
      })
        .catch((error) => {
        success.value = false
            message.value = error.response?.data?.message ?? "Une erreur s'est produite"
            console.log(message.value)
      })
  }
  
  const storeTask = async (data) => {
    await Api.post('/task/store', data)
      .then((response) => {
          if (response.status === 200) {
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
        })

        errors.value = newError
      } else {
        errors.value.general = error.response?.data?.message ?? "Une erreur s'est produite"
      }
    } else {
            errors.value.general  = error.response?.data?.message ?? "Une erreur s'est produite"
        }
        
      })
    }
    
  
    const searchUser = async (data) => {
    await Api.post('/users', data)
      .then((response) => {
        console.log('res', response)
          if (response.status === 200) {
            success.value = true
            users.value = response.data
        }
      })
      .catch((error) => {
          console.log("error", error)
        success.value = false
        errors.value.general  = error.response?.data?.message ?? "Une erreur s'est produite"
        
      })
  }
  
   const updateTask = async (data, id) => {
    await Api.put(`/task/update/${id}`, data)
      .then((response) => {
        console.log('res', response)
          if (response.status === 200) {
            success.value = true
            users.value = response.data
        }
      })
      .catch((error) => {
          console.log("error", error)
        success.value = false
        errors.value.general  = error.response?.data?.message ?? "Une erreur s'est produite"
        
      })
  }

  const assignTask = async (data) => {
    await Api.post(`/task/assign`, data)
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
      if(error.response?.data?.data){
        const dataErrors = error.response.data.data
        Object.keys(dataErrors).forEach(key => {
          const errorMessages = dataErrors[key];
          newError[`${key}`] = errorMessages[0]
        })

        errors.value = newError
      } else {
        errors.value.general = error.response?.data?.message ?? "Une erreur s'est produite"
      }
    } else {
            errors.value.general  = error.response?.data?.message ?? "Une erreur s'est produite"
        }
      })
  }
  
  const getTask = async (id) => {
    await Api.get(`/task/detail/${id}`)
      .then((response) => {
        console.log("res", response)
          if (response.status === 200) {
            success.value = true
            task.value = response.data.data
        }
      })
      .catch((error) => {
        success.value = false
        errors.value.general  = error.response?.data?.message ?? "Une erreur s'est produite"
      })
    }
  return {
      homeData,
    getProjectTasks,
    storeTask,
    searchUser,
    updateTask,
    getTask,assignTask,
      errors,
      projects,
      tasks,
      taskPaginationData,
      defaultProject,
      message,
    success,
    users,
    task
  }
}
