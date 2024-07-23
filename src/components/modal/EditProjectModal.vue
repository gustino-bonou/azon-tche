<template>
  <div
    class="modal fade"
    id="editProjectModal"
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
              New Project
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
          <form @submit.prevent="doUpdateProject">
            <div class="mb-3">
              <label for="taskTitle" class="form-label">Name</label>
              <input
                type="text"
                class="form-control"
                id="taskTitle"
                v-model="form.name"
                
              />
            </div>
            <div class="d-flex justify-content-start mt-3">
              <button
                type="submit"
                class="btn-save py-2 me-4 save"
                v-if="!isLoading"
                :disabled="!form.name"
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
import { ref, reactive , watch} from "vue";
import * as bootstrap from "bootstrap";
import projectService from "../../service/project_service";

export default {
  props: {
    project: {
      type: Object,
      required: true,
    },
  },
  components: {},

  emits: ["dataFresh"],

  setup(props, emit) {
    const form = reactive({
      name: props.project?.name,
      project_id: props.project?.id
    });

    const requestError = ref({
      name: "",
      general: "",
    });

    const resetForm = () => {
      form.name = "";
    };

    const { success, errors, updateProject } = projectService();

    const isLoading = ref(false);

    const currentMoment = ref("");
    const doUpdateProject = async () => {
      isLoading.value = true;
      await updateProject(form, form.project_id).then(() => {
        if (success.value) {
          resetForm();
          closeModal();
          emit.emit("dataFresh");
        } else {
          requestError.value = errors.value;
        }
        isLoading.value = false;
      });
    };

    const closeModal = () => {
      const taskModalElement = document.getElementById("editProjectModal");
      const modal = bootstrap.Modal.getInstance(taskModalElement);
      if (modal) {
        modal.hide();
      }
    };

    watch(
      () => props.project,
      (newVal) => {
        console.log('project', props.project)
        if (newVal) {
          form.name = newVal.name;
          form.project_id = newVal.id;
        }
      },
      { immediate: true }
    );

    return {
      doUpdateProject,
      closeModal,
      isLoading,
      form,
      currentMoment,
      requestError,
    };
  },
};
</script>