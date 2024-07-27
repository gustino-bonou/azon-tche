<template>
  <div class="view-content me-2">
    <div class="d-flex flex-row justify-content-end flex-wrap mb-3">
      <div
        class="new-task text-center d-flex flex-row justify-content-between mb-2"
        @click="openModal"
      >
        <span>New project</span>
        <svg
          fill="#000000"
          width="30px"
          height="30px"
          viewBox="0 0 24 24"
          id="add-file-12"
          data-name="Flat Line"
          xmlns="http://www.w3.org/2000/svg"
          class="icon flat-line"
        >
          <path
            id="secondary"
            d="M12.5,19A6.5,6.5,0,0,0,6,12.5V7l4-4h9a1,1,0,0,1,1,1V20a1,1,0,0,1-1,1H12.18A6.3,6.3,0,0,0,12.5,19Z"
            style="fill: rgb(44, 169, 188); stroke-width: 2"
          ></path>
          <path
            id="primary"
            d="M4,19H8M6,21V17m8-4h2m0-4H10"
            style="
              fill: none;
              stroke: rgb(0, 0, 0);
              stroke-linecap: round;
              stroke-linejoin: round;
              stroke-width: 2;
            "
          ></path>
          <path
            id="primary-2"
            data-name="primary"
            d="M6,13V7l4-4h9a1,1,0,0,1,1,1V20a1,1,0,0,1-1,1H12"
            style="
              fill: none;
              stroke: rgb(0, 0, 0);
              stroke-linecap: round;
              stroke-linejoin: round;
              stroke-width: 2;
            "
          ></path>
        </svg>
      </div>
    </div>
    <AddProjectModal ref="addProjectModal" @dataFresh="fetchProjects" />

    <EditProjectModal
      :project="selectedProject"
      @dataFresh="fetchProjects"
      ref="addTaskModal"
    />

    <div class="text-center py-3" v-if="isLoading">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <div class="text-center py-3" v-if="showEmptyComponent()">
      <h3 class="text-white">You have any project</h3>
    </div>

    <div class="text-center py-3" v-else-if="errorMessage">
      <h4 class="text-white">{{ errorMessage }}</h4>
    </div>

    <div v-if="showDataComponent()" class="row">
      <div
        class="col-md-3"
        v-for="(project, index) in userProjects"
        :key="index"
      >
        <div
          class="text-white project-item mb-3"
          @click="openEditModal(project)"
        >
          {{ truncate(project.name, 40) }}
          <span
            v-if="project.user_id === currenUser.id"
            class="badge bg-success ms-2"
            >You</span
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, inject } from "vue";
import projectService from "../../service/project_service";
import AddProjectModal from "../modal/AddProjectModal.vue";
import EditProjectModal from "../modal/EditProjectModal.vue";
import { Modal } from "bootstrap";
import userIcon from "@/assets/icon/user.png";
import useAlertNotification from "@/components/notifications/useNotification";

export default {
  components: {
    AddProjectModal,
    EditProjectModal,
  },
  setup() {
    const isLoading = ref(false);
    const userProjects = ref([]);
    const errorMessage = ref("");
    const selectedProject = ref("");
    const currenUser = inject("user");

    const { projects, success, message, getProjects } = projectService();
    const { errorMsg } = useAlertNotification();

    const openModal = () => {
      const taskModalElement = new Modal(
        document.getElementById("addProjectModal")
      );
      taskModalElement.show();
    };

    const selectProject = (project) => {
      selectedProject.value = project;
      console.log("ee", selectedProject.value);
    };
    const openEditModal = (project) => {
      if (currenUser.value.id !== project.user_id) {
        errorMsg("Action non authorizé");
        return;
      }
      selectedProject.value = project;
      const taskModalElement = new Modal(
        document.getElementById("editProjectModal")
      );
      taskModalElement.show();
    };

    const fetchProjects = async () => {
      console.log("ok");
      isLoading.value = true;
      await getProjects().then(() => {
        if (success.value) {
          userProjects.value = projects.value;
        } else {
          errorMessage.value = message.value;
        }
        isLoading.value = false;
      });
    };

    const truncate = (text, length) => {
      if (text?.length > length) {
        return text.substring(0, length) + "...";
      }
      return text;
    };

    onMounted(async () => {
      await fetchProjects();
    });

    const showDataComponent = () => {
      return !isLoading.value && userProjects.value?.length > 0;
    };

    const showEmptyComponent = () => {
      return (
        !isLoading.value &&
        userProjects.value.length === 0 &&
        !errorMessage.value
      );
    };

    return {
      isLoading,
      showDataComponent,
      fetchProjects,
      showEmptyComponent,
      selectProject,
      selectedProject,
      userProjects,
      errorMessage,
      userIcon,
      currenUser,
      openModal,
      openEditModal,
      truncate,
    };
  },
};
</script>

<style scoped>
@import "../../assets/css//tasks.css";
</style>
