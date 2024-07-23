<template>
  <div
    class="modal fade"
    id="editTaskModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div
          class="modal-header d-flex flex-row justify-content-between"
          style="background-size: cover"
        >
          <div>
            <h5
              class="modal-title text-white"
              id="staticBackdropLabel text-white"
              @click="consoleData"
            >
              Update Task
            </h5>
          </div>
          <div>
            <button
              type="button"
              class="close-modal"
              data-bs-dismiss="modal"
              aria-label="Close"
            >
              <svg
                width="25"
                height="25"
                viewBox="0 0 25 25"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M21.9999 6.63494L18.3624 2.99744L11.9999 9.35994L5.63738 2.99744L1.99988 6.63494L8.36238 12.9974L1.99988 19.3599L5.63738 22.9974L11.9999 16.6349L18.3624 22.9974L21.9999 19.3599L15.6374 12.9974L21.9999 6.63494Z"
                  fill="#01212E"
                  class="pb-2"
                />
              </svg>
            </button>
          </div>
        </div>
        <div class="modal-body">
          <form @submit.prevent="doUpdateTask">
            <div class="mb-3">
              <label for="taskTitle" class="form-label">Title</label>
              <input
                type="text"
                class="form-control"
                id="taskTitle"
                v-model="form.title"
                required
              />
            </div>
            <div class="mb-3">
              <label for="taskDescription" class="form-label"
                >Description</label
              >
              <textarea
                class="form-control"
                id="taskDescription"
                v-model="form.description"
              ></textarea>
            </div>
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="taskPriority" class="form-label">Priority</label>
                <select
                  class="form-select"
                  id="taskPriority"
                  v-model="form.priority"
                  required
                >
                  <option value="height">High</option>
                  <option value="medium">Medium</option>
                  <option value="low">Low</option>
                </select>
              </div>
              <div class="mb-3 col-md-6">
                <label for="taskPriority" class="form-label">Status</label>
                <select
                  class="form-select"
                  id="taskPriority"
                  v-model="form.status"
                  required
                >
                  <option value="ended">Done</option>
                  <option value="in_progress">In progress</option>
                  <option value="pending">Pending</option>
                </select>
              </div>
            </div>

            <div class="mb-5">
              <label for="taskDeadline" class="form-label">Deadline</label>
              <input
                type="datetime-local"
                class="form-control"
                id="taskDeadline"
                :min="currentMoment"
                v-model="form.deadline"
              />
            </div>

            <div class="d-flex justify-content-start mt-3">
              <button
                type="submit"
                class="btn-save py-2 me-4 save"
                @click="doStoreTask"
                v-if="!isLoading"
                :disabled="!form.title"
              >
                Save
              </button>
              <button
                type="submit"
                class="btn btn-save py-2 me-3"
                v-if="isLoading"
              >
                <div class="spinner-grow spinner-grow-sm" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </button>
              <button
                class="btn-save cancel py-2 me-2"
                type="submit"
                data-bs-dismiss="modal"
              >
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive, onMounted, watch } from "vue";
import taskService from "../../service/task_service";
import * as bootstrap from "bootstrap";

export default {
  props: {
    task: {
      type: Object,
      required: true,
    },
  },
  components: {},

  emits: ["dataFresh"],

  setup(props, emit) {
    const form = reactive({
      title: "",
      description: "",
      priority: "",
      deadline: "",
      status: "",
      task_id: "",
    });

    const requestError = ref({
      title: "",
      description: "",
      priority: "",
      deadline: "",
      status: "",
      general: "",
    });

    const { success, errors, searchUser, updateTask, users } = taskService();

    const isLoading = ref(false);

    const currentMoment = ref("");

    const searchUserText = ref("");
    const userSuggestions = ref([]);

    const getCurrentDateTime = () => {
      const now = new Date();
      return now.toISOString().slice(0, 16);
    };

    onMounted(() => {
      currentMoment.value = getCurrentDateTime();
    });

    const doUpdateTask = async () => {
      if (searchUserText.value) isLoading.value = true;
      await updateTask(form, form.task_id).then(() => {
        if (success.value) {
          closeModal();
          emit.emit("dataFresh");
        } else {
          requestError.value = errors.value;
        }
        isLoading.value = false;
      });
    };

    const doSeachUser = async () => {
      const data = { query: searchUserText.value };
      if (searchUserText.value?.length > 2) {
        await searchUser(data).then(() => {
          if (success.value) {
            userSuggestions.value = users.value;
          }
        });
      }
    };

    const resetForm = () => {
      form.deadline = "";
      form.description = "";
      form.title = "";
      form.priority = "";
      form.status = "";
    };

    const closeModal = () => {
      resetForm();
      const taskModalElement = document.getElementById("editTaskModal");
      const modal = bootstrap.Modal.getInstance(taskModalElement);
      if (modal) {
        modal.hide();
      }
    };

    const selectUser = (user) => {
      form.done_by = user.id;
      searchUserText.value = user.email;
      userSuggestions.value = [];
    };

    watch(
      () => props.task,
      (newVal) => {
        if (props.task) {
          form.title = newVal.title;
          form.description = newVal.description;
          form.deadline = newVal.deadline;
          form.status = newVal.status;
          form.priority = newVal.priority;
          form.done_by = newVal.user?.id;
          form.task_id = newVal.id;
        }
      },
      { immediate: true }
    );

    return {
      getCurrentDateTime,
      doUpdateTask,
      closeModal,
      resetForm,
      doSeachUser,
      selectUser,
      isLoading,
      form,
      currentMoment,
      requestError,
      searchUserText,
      userSuggestions,
    };
  },
};
</script>