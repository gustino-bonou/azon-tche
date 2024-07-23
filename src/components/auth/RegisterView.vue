<template>
  <div class="login-page d-flex align-items-center justify-content-center">
    <div class="text-center p-4">
      <form autocomplete="off" @submit.prevent="doRegister">
        <h1 class="login-text text-white">Sign Up</h1>
        <div class="align-content-center justify-content-center">
          <div
            class="d-flex flex-column form-group position-relative first-input"
          >
            <input
              type="text"
              placeholder="Name"
              class="form-control"
              v-model="formData.name"
            />
            <div class="position-absolute icon d-flex">
              <img
                :src="userIcon"
                alt=""
                class="input-icon"
                :style="{ width: '30px', height: '30px' }"
              />
            </div>
          </div>
          <div v-if="errorData.name" class="error">{{ errorData.name }}</div>
        </div>

        <div
          class="d-flex flex-column align-content-center justify-content-center"
        >
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
          <div v-if="errorData.email" class="error text-start">
            {{ errorData.email }}
          </div>
        </div>

        <div
          class="d-flex flex-column align-content-center justify-content-center"
        >
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
        </div>
        <div v-if="errorData.password" class="error">
          {{ errorData.password }}
        </div>

        <button class="login-btn" :disabled="disabledBtn()" type="submit">
          Sign up
        </button>
        <div class="text-white text-end">
          Have account ?
          <router-link class="link ms-2" to="/login">Sign in</router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import emailIcon from "@/assets/icon/email.png";
import cadenas from "@/assets/icon/cadenas.png";
import userIcon from "@/assets/icon/user.png";
import useAuthService from "../../service/auth_service";
import useAlertNotification from "@/components/notifications/useNotification";

import { reactive, ref } from "vue";
//const { errorMsg, successMsg } = useAlertNotification()
//import useAlertNotification from '@/services/notifications/useNotification.js'
export default {
  setup() {
    const isLoading = ref(false);

    const formData = reactive({
      name: "",
      email: "",
      password: "",
    });

    const errorData = ref({
      email: "",
      password: "",
      name: "",
      general: "",
    });

    const disabledBtn = () => {
      return (
        !formData.email ||
        !formData.password ||
        !formData.name ||
        isLoading.value === true
      );
    };

    const { success, errors, register } = useAuthService();
    const { errorMsg, successMsg } = useAlertNotification();

    const doRegister = async () => {
      isLoading.value = true;
      await register(formData).then(async () => {
        isLoading.value = false;
        if (success.value == true) {
          errorData.value = {};
          successMsg("Inscription réussie");
          window.location.pathname = "/";
        } else {
          errorData.value = errors.value;
          errorData.value = errors.value;
          if (errorData.value.general) {
            errorMsg(errorData.value.general);
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
      userIcon,
      disabledBtn,
      errorData,
      cadenas,
      isLoading,
      doRegister,
    };
  },
};
</script>



<style scoped>
@import "../../assets/css//login.css";
</style>