<template>
  <div class="view-content me-2">
    <div class="d-flex flex-row justify-content-between flex-wrap mb-3 mt-3">
      <div class="custom-select-wrapper mb-2">
        <select
          class="form-select custom-select c-form-select"
          v-model="selectedProject"
          @change="onProjectChange"
        >
          <option
            v-for="project in userProjects"
            :key="project.id"
            :value="project.id"
          >
            {{ truncate(project.name, 10) }}
          </option>
        </select>
        <div class="custom-icon">
          <svg
            width="30px"
            height="30px"
            viewBox="0 0 1024 1024"
            class="icon"
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M401.9 584.7h16v16h-16zM385.9 600.7h-16v-16h16v16z m-31.9 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-31.9 0h-16v-16h16v16zM146.1 584.7h16v16h-16zM162.1 569h-16v-15.7h16V569z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16v-15.7h16V506z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16v-15.7h16V443z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16v-15.7h16V380z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16v-15.7h16V317z m0-31.4h-16v-15.7h16v15.7zM146.1 238.1h16v16h-16zM385.9 254.1h-16v-16h16v16z m-31.9 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-31.9 0h-16v-16h16v16zM401.9 238.1h16v16h-16zM417.9 569h-16v-15.7h16V569z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16v-15.7h16V506z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16v-15.7h16V443z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16v-15.7h16V380z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16v-15.7h16V317z m0-31.4h-16v-15.7h16v15.7zM860.1 682.9h16v16h-16zM844.2 698.9h-16v-16h16v16z m-32 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-31.9 0h-16v-16h16v16z m-32 0h-16v-16h16v16zM604.3 682.9h16v16h-16zM620.3 667.1h-16v-15.7h16v15.7z m0-31.4h-16V620h16v15.7z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16V557h16v15.7z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16V494h16v15.7z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16V431h16v15.7z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16V368h16v15.7zM604.3 336.2h16v16h-16zM844.2 352.2h-16v-16h16v16z m-32 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-32 0h-16v-16h16v16z m-31.9 0h-16v-16h16v16z m-32 0h-16v-16h16v16zM860.1 336.2h16v16h-16zM876.1 667.1h-16v-15.7h16v15.7z m0-31.4h-16V620h16v15.7z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16V557h16v15.7z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16V494h16v15.7z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16V431h16v15.7z m0-31.5h-16v-15.7h16v15.7z m0-31.5h-16V368h16v15.7z"
              fill="#0A0408"
            />
            <path d="M246.9 107.8h531.6v531.6H246.9z" fill="#FFFFFF" />
            <path
              d="M786.5 647.4H238.9V99.8h547.6v547.6z m-531.6-16h515.6V115.8H254.9v515.6z"
              fill="#0A0408"
            />
            <path d="M305.1 166h415.1v415.1H305.1z" fill="#55B7A8" />
            <path
              d="M389.9 238.2h195.3v16H389.9zM384.6 338.8h256.2v16H384.6zM384.6 441.2h256.2v16H384.6z"
              fill="#0A0408"
            />
            <path d="M868.8 918H156.5l-50-415.4h812.3z" fill="#FFFFFF" />
            <path
              d="M875.9 926H149.4L97.5 494.6h830.4l-52 431.4z m-712.3-16h698.1l48.1-399.4H115.5L163.6 910z"
              fill="#0A0408"
            />
            <path d="M809.6 866.5H215.8L174.1 554h677.2z" fill="#F4BE6F" />
            <path
              d="M154.1 639.7h154.3v16H154.1zM154.1 717.9h258.3v16H154.1z"
              fill="#FFFFFF"
            />
            <path d="M842.7 318.8h50.9v50.9h-50.9z" fill="#DC444A" />
            <path
              d="M901.6 377.7h-66.9v-66.9h66.9v66.9z m-50.9-16h34.9v-34.9h-34.9v34.9z"
              fill="#0A0408"
            />
            <path d="M128.6 220.8h50.9v50.9h-50.9z" fill="#DC444A" />
            <path
              d="M187.5 279.7h-66.9v-66.9h66.9v66.9z m-50.9-16h34.9v-34.9h-34.9v34.9z"
              fill="#0A0408"
            />
          </svg>
        </div>
      </div>

      <div class="custom-select-wrapper mb-2">
        <select
          v-model="filterable.priority"
          class="form-select c-form-select custom-select"
          @change="fetchProjectTasks"
        >
          <option value="" selected disabled>Priority</option>
          <option value="height">High</option>
          <option value="medium">Medium</option>
          <option value="low">Low</option>
        </select>
        <div class="custom-icon">
          <svg
            width="30px"
            height="30px"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M15 10.5A3.502 3.502 0 0 0 18.355 8H21a1 1 0 1 0 0-2h-2.645a3.502 3.502 0 0 0-6.71 0H3a1 1 0 0 0 0 2h8.645A3.502 3.502 0 0 0 15 10.5zM3 16a1 1 0 1 0 0 2h2.145a3.502 3.502 0 0 0 6.71 0H21a1 1 0 1 0 0-2h-9.145a3.502 3.502 0 0 0-6.71 0H3z"
              fill="#01212E"
            />
          </svg>
        </div>
      </div>

      <div class="custom-select-wrapper mb-2">
        <select
          v-model="filterable.status"
          class="form-select c-form-select custom-select"
          @change="fetchProjectTasks"
        >
          <option value="" selected disabled>Status</option>
          <option value="ended">Done</option>
          <option value="in_progress">In progress</option>
          <option value="pending">Pending</option>
        </select>
        <div class="custom-icon">
          <svg
            width="30px"
            height="30px"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M15 10.5A3.502 3.502 0 0 0 18.355 8H21a1 1 0 1 0 0-2h-2.645a3.502 3.502 0 0 0-6.71 0H3a1 1 0 0 0 0 2h8.645A3.502 3.502 0 0 0 15 10.5zM3 16a1 1 0 1 0 0 2h2.145a3.502 3.502 0 0 0 6.71 0H21a1 1 0 1 0 0-2h-9.145a3.502 3.502 0 0 0-6.71 0H3z"
              fill="#01212E"
            />
          </svg>
        </div>
      </div>

      <div
        class="new-task text-center d-flex flex-row justify-content-between mb-2"
        @click="openModal"
      >
        <span>New task</span>
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
    <AddTaskModal
      :projectId="selectedProject"
      @dataFresh="fetchProjectTasks"
      ref="addTaskModal"
    />

    <EditTaskModal
      :task="selectedTask"
      @dataFresh="fetchProjectTasks"
      ref="addTaskModal"
    />
    <AssignTaskModal
      :task="selectedTask"
      @dataFresh="fetchProjectTasks"
      ref="assignTaskModal"
    />

    <div class="text-center py-3" v-if="isLoading">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <div class="text-center py-3" v-if="showEmptyComponent()">
      <h3 class="text-white">You have any task</h3>
    </div>

    <div class="text-center py-3" v-else-if="errorMessage">
      <h4 class="text-white">{{ errorMessage }}</h4>
    </div>

    <div v-if="showDataComponent()" class="row">
      <div
        class="col-md-4 col-lg-3"
        v-for="(task, index) in projectTasks"
        :key="index"
      >
        <div
          class="card mb-3 task-item d-flex flex-column align-content-between justify-content-between"
        >
          <div @click="openEditModal(task)">
            <h5 class="card-title">{{ truncate(task.title, 30) }}</h5>

            <div class="d-flex flex-row justify-content-between">
              <p class="card-text">
                <span
                  :class="priorityClass(task.priority)"
                  class="text-uppercase"
                  >{{ task.priority }}</span
                >
              </p>

              <p class="card-text">
                <span
                  :class="statusClass(task.status)"
                  class="text-uppercase p-1"
                  >{{ statusValue(task.status) }}</span
                >
              </p>
            </div>
            <p
              :style="deadlineStyle(task)"
              class="text-end"
              :class="deadlineClass(task)"
            >
              {{ formatDate(task.deadline) }}
            </p>
          </div>
          <div
            class="d-flex justify-content-between done-by"
            @click="openAssignTaskModal(task)"
          >
            <img
              :src="userIcon"
              alt=""
              class="input-icon"
              :style="{ width: '30px', height: '30px' }"
            />
            <p class="text-white opacity-50 me-2">
              {{ task.doneBy?.email ?? task.author?.email }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive, ref, onMounted, watch } from "vue";
import taskService from "../../service/task_service";
import AddTaskModal from "../modal/AddTaskModal.vue";
import EditTaskModal from "../modal/EditTaskModal.vue";
import AssignTaskModal from "../modal/AssignTaskModal.vue";
import { Modal } from "bootstrap";
import userIcon from "@/assets/icon/user.png";

export default {
  components: {
    AddTaskModal,
    EditTaskModal,
    AssignTaskModal,
  },
  setup() {
    const isLoading = ref(false);
    const userProjects = ref([]);
    const projectTasks = ref([]);
    const paginator = ref([]);
    const errorMessage = ref("");
    const selectedProject = ref("");
    const selectedTask = ref("");

    const requestData = reactive({
      email: "",
      password: "",
    });

    const filterable = reactive({
      priority: "",
      status: "",
      project_id: selectedProject.value,
    });

    const {
      homeData,
      projects,
      taskPaginationData,
      tasks,
      success,
      message,
      defaultProject,
      getProjectTasks,
    } = taskService();

    const openModal = () => {
      const taskModalElement = new Modal(
        document.getElementById("addTaskModal")
      );
      taskModalElement.show();
    };

    const openEditModal = (task) => {
      selectedTask.value = task;
      const taskModalElement = new Modal(
        document.getElementById("editTaskModal")
      );
      taskModalElement.show();
    };
    const openAssignTaskModal = (task) => {
      selectedTask.value = task;
      const taskModalElement = new Modal(
        document.getElementById("assignTaskModal")
      );
      taskModalElement.show();
    };

    const fetchHomeData = async () => {
      isLoading.value = true;
      await homeData(requestData).then(() => {
        if (success.value) {
          userProjects.value = projects.value;
          projectTasks.value = tasks.value;
          paginator.value = taskPaginationData.value;
          errorMessage.value = "";
          selectedProject.value = defaultProject.value.id;
          console.log("index", selectedProject.value);
        } else {
          errorMessage.value = message.value;
        }
        isLoading.value = false;
      });
    };

    onMounted(async () => {
      await fetchHomeData();
    });

    const fetchProjectTasks = async () => {
      isLoading.value = true;
      await getProjectTasks(filterable).then(() => {
        if (success.value) {
          projectTasks.value = tasks.value;
          paginator.value = taskPaginationData.value;
          errorMessage.value = "";
        } else {
          errorMessage.value = message.value;
        }
        isLoading.value = false;
      });
    };

    const onProjectChange = async () => {
      if (selectedProject.value) {
        filterable.priority = "";
        filterable.status = "";
        await fetchProjectTasks();
      }
    };

    const showDataComponent = () => {
      return !isLoading.value && projectTasks.value?.length > 0;
    };

    const showEmptyComponent = () => {
      return (
        !isLoading.value &&
        projectTasks.value.length === 0 &&
        !errorMessage.value
      );
    };

    const statusClass = (status) => {
      switch (status) {
        case "ended":
          return "badge bg-success";
        case "in_progress":
          return "badge bg-warning";
        case "pending":
          return "badge bg-secondary";
        default:
          return "badge bg-secondary";
      }
    };

    const statusValue = (status) => {
      switch (status) {
        case "ended":
          return "Done";
        case "in_progress":
          return "In progress";
        case "pending":
          return "Pending";
        default:
          return "Non démarrée";
      }
    };

    const priorityClass = (priority) => {
      switch (priority) {
        case "height":
          return "text-danger";
        case "medium":
          return "text-warning";
        case "low":
          return "text-info";
        default:
          return "text-secondary";
      }
    };

    const formatDate = (dateString) => {
      const options = {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      };
      const date = new Date(dateString);
      return dateString !== null
        ? new Intl.DateTimeFormat("fr-FR", options).format(date)
        : "";
    };

    const isDeadlineOverdue = (deadline) => {
      const now = new Date();
      const deadlineDate = new Date(deadline);
      const isSameDay = now.toDateString() === deadlineDate.toDateString();
      return deadlineDate < now || isSameDay;
    };

    const deadlineClass = (task) => {
      return isDeadlineOverdue(task.deadline) && task.status !== "ended"
        ? ""
        : " d-none";
    };
    const deadlineStyle = (task) => {
      return isDeadlineOverdue(task.deadline) && task.status !== "ended"
        ? "font-size: 15px; color: rgb(150, 55, 55)"
        : "";
    };

    const truncate = (text, length) => {
      if (text?.length > length) {
        return text.substring(0, length) + "...";
      }
      return text;
    };

    watch(
      () => selectedProject,
      (newVal) => {
        filterable.project_id = newVal;
      },
      { immediate: true }
    );

    return {
      isLoading,
      fetchHomeData,
      showDataComponent,
      showEmptyComponent,
      fetchProjectTasks,
      onProjectChange,
      userProjects,
      selectedProject,
      selectedTask,
      projectTasks,
      paginator,
      errorMessage,
      filterable,
      userIcon,
      openModal,
      statusClass,
      priorityClass,
      formatDate,
      deadlineClass,
      deadlineStyle,
      statusValue,
      truncate,
      openEditModal,
      openAssignTaskModal,
    };
  },
};
</script>

<style scoped>
@import "../../assets/css//tasks.css";
</style>
