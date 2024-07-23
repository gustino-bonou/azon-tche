<!-- App.vue -->
<template>
  <router-view></router-view>
</template>


<script>
import { provide, ref, onMounted, inject } from "vue";
import useAuthService from "../src/service/auth_service";

export default {
  setup() {
    const { success, currentUser, getAuthUser } = useAuthService();
    const user = ref(null);

    onMounted(async () => {
      await getAuthUser().then(() => {
        if (success.value) {
          user.value = currentUser.value;
          console.log("in app vue ", user.value);
        }
      });
    });

    provide("user", user);
    const testu = inject("user", user);
    console.log("innnnn", testu)

    return {};
  },
};
</script>