<template>
  <div class="d-flex align-items-center justify-content-center login-page">
    <div class="text-center p-4 login-container ">
      <form autocomplete="off" @submit.prevent="doLogin">
        <h1 class="login-text text-white">Sign in</h1>
        <div class="form-group position-relative first-input">
          <input
            type="email"
            placeholder="Email"
            class="form-control"
            v-model="formData.email"
          />
          <div class="position-absolute icon d-flex">
            <img
              :src="emailIcon"
              alt=""
              class="input-icon"
              :style="{ width: '30px', height: '30px' }"
            />
          </div>
        </div>
        <div v-if="errorData.email" class="error">
          {{ errorData.email }}
        </div>
        <div class="form-group position-relative mb-3 first-input">
          <input
            type="password"
            placeholder="Password"
            class="form-control password"
            v-model="formData.password"
          />
          <div class="position-absolute icon-password d-flex">
            <img
              :src="cadenas"
              alt=""
              class="input-icon"
              :style="{ width: '30px', height: '30px' }"
            />
          </div>
        </div>
        <div v-if="errorData.password" class="error">
          {{ errorData.password }}
        </div>
        <button class="login-btn" :disabled="disabledBtn()" type="submit">
          Login
        </button>
        <div class="text-white text-end">
          Dont have account ?
          <router-link class="link ms-2" to="/register">Sign up</router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import emailIcon from "@/assets/icon/email.png";
import cadenas from "@/assets/icon/cadenas.png";
import useAuthService from "../../service/auth_service";
import useAlertNotification from '@/components/notifications/useNotification'


import { reactive, ref } from "vue";
//const { errorMsg, successMsg } = useAlertNotification()
//import useAlertNotification from '@/services/notifications/useNotification.js'
export default {
  setup() {
    const isLoading = ref(false);

    const formData = reactive({
      email: "",
      password: "",
    });

    const errorData = ref({
      email: "",
      password: "",
      general: "",
      // Ajoutez d'autres erreurs si nécessaire
    });

    const disabledBtn = () => {
      return !formData.email || !formData.password || isLoading.value === true;
    };

    const { success, errors, login } = useAuthService();

        const { errorMsg, successMsg } = useAlertNotification()


    const doLogin = async () => {
      isLoading.value = true;
      await login(formData).then(async () => {
        isLoading.value = false;
        if (success.value == true) {
          errorData.value = {};
          successMsg("Connexion réussie")
          window.location.pathname = "/";
        } else {
          errorData.value = errors.value;
          if (errorData.value.general) {
            errorMsg(errorData.value.general)
          }
        }
      });
    };

    /* const validatePassword = () => {
      const password = formConnexion.password
      const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/

      if (!passwordRegex.test(password)) {
        erreurs.password = [
          'Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial'
        ]
        disabledBtn.value = true
      } else {
        erreurs.password = ''
        disabledBtn.value = false
      }
    } */

    return {
      formData,
      emailIcon,
      disabledBtn,
      errorData,
      cadenas,
      isLoading,
      doLogin,
    };
  },
};
</script>



<style scoped>
@import "../../assets/css//login.css";
</style>