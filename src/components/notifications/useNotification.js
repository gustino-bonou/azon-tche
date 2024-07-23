import { createToaster } from "@meforma/vue-toaster"
//import { useToast } from "vue-toastification"

const toaster = createToaster({ /* options */ })
//const toast = useToast()

export default function useAlertNotification() {

  const successMsg = msg => {
    toaster.success(msg,{
      position: 'top-right'
    })
  }

  const infoMsg = msg => {
    toaster.info(msg,{
      position: 'top-right'
    })
  }

  const errorMsg = msg => {
    toaster.error(msg,{
      position: 'top-right'
    })
  }

  return {
    successMsg,
    errorMsg,
    infoMsg
  }
}
