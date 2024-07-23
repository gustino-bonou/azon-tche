<template>
  <div class="container-fluid">
    <div
      class="header d-flex flex-row justify-content-between align-content-center"
    >
      <div class="m-3">
        <img
          :src="listImage"
          alt=""
          class="input-icon"
          :style="{ width: '100px', height: '100px' }"
        />
      </div>
      <div class="m-3">
        <b-dropdown>
          <template #button-content>
            <b-button class="">{{ user?.name }}</b-button>
          </template>
          <b-dropdown-item>Logout </b-dropdown-item>
          <b-dropdown-item>Profile</b-dropdown-item>
        </b-dropdown>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-2">
        <b-navbar toggleable="lg" class="flex-column mt-2">
          <b-navbar-toggle
            target="nav-collapse"
            class="text-bg-light mb-3"
          ></b-navbar-toggle>
          <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav class="flex-column">
              <router-link
                to="/"
                class="navigate-item mb-3 d-flex flex-column align-content-center justify-content-center"
                ><b-nav-item class="text-white">Tasks</b-nav-item></router-link
              >
              <router-link to="/projects" class="navigate-item">
                <b-nav-item class="text-white"> Projects</b-nav-item>
              </router-link>
            </b-navbar-nav>
          </b-collapse>
        </b-navbar>
      </div>
      <div class="col-lg-10">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>
 



<script>
import { provide, ref, onMounted, inject } from "vue";
import listImage from "@/assets/images/logo-tche.png";
import useAuthService from "../../service/auth_service";

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
    inject("user", user);

    return {
      listImage,
      user
    };
  },
};
</script>


<style scoped>
.navbar-nav {
  width: 100%;
}

.nav-item {
  width: 100%;
}
</style>
