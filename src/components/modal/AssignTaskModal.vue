<template>
  <div
    class="modal fade"
    id="assignTaskModal"
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
              Assign Task
            </h5>
          </div>
          <div>
            <button
              type="button"
              class="close-modal"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="resetData"
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
          <form @submit.prevent="doAssignTask">
            <div class="col-md-6">
              <label for="taskUser" class="form-label">Assign to</label>
              <input
                type="text"
                class="form-control"
                id="taskUser"
                v-model="searchUserText"
                @input="doSeachUser"
              />
            </div>
            <div>
              <div v-if="requestError.general" class="text-danger">
                {{ requestError.general }}
              </div>
              <div v-else-if="requestError.email"></div>
            </div>
            <ul v-if="userSuggestions?.length" class="list-group">
              <li
                class="list-group-item"
                v-for="user in userSuggestions"
                :key="user.id"
                @click="selectUser(user)"
              >
                {{ user.email }}
              </li>
            </ul>
            <div class="d-flex justify-content-start mt-5">
              <button
                type="submit"
                class="btn-save py-2 me-4 save"
                @click="doStoreTask"
                v-if="!isLoading"
                :disabled="!searchUserText || task.doneBy?.email === searchUserText"
              >
                Assign
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

               type="button"
              class="close-modal btn-save cancel py-2 me-2"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="resetData"

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
      task_id: props.task.id,
      odl_email: props.task.doneBy?.email,
    });

    const requestError = ref({
      email: "",
      general: "",
      task_id: "",
    });

    const { success, errors, searchUser, assignTask, users } = taskService();

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

    const doAssignTask = async () => {
      isLoading.value = true;
      const data = { task_id: form.task_id, email: searchUserText.value };
      await assignTask(data).then(() => {
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
            if (userSuggestions.value.length === 0) {
              requestError.value.general = "Aucun utilisateur trouvé";
            } else {
              requestError.value.general = "";
            }
          }
        });
      }
    };

    const closeModal = () => {
      resetData()
      const taskModalElement = document.getElementById("assignTaskModal");
      const modal = bootstrap.Modal.getInstance(taskModalElement);
      if (modal) {
        modal.hide();
      }
    };

    const resetData = () => {
      requestError.value.email = "";
      requestError.value.general = "";
      requestError.value.task_id = "";
      form.odl_email = "";
    };

    const selectUser = (user) => {
      form.done_by = user.id;
      searchUserText.value = user.email;
      userSuggestions.value = [];
    };

    const disableBtn = () => {
      return (searchUserText.value ==! "" && (form.odl_email === searchUserText.value))
    }

    watch(
      () => props.task,
      (newVal) => {
        searchUserText.value = newVal.doneBy?.email;
        form.task_id = newVal.id;
        form.odl_email = newVal.doneBy?.email;
      },
      { immediate: true }
    );

    return {
      getCurrentDateTime,
      doAssignTask,
      closeModal,
      doSeachUser,
      selectUser,
      resetData,
      disableBtn,
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