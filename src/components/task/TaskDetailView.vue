<template>
  <div class="view-content me-2">
    <div class=" m-5">
      <div class="card">
        <div class="card-header text-white detail-header">
          <h2>Task Details</h2>
        </div>
        <div class="card-body">
          <h3 class="card-title text-black">{{ selectedTask.title }}</h3>
          <p class="card-text">{{ selectedTask.description }}</p>
          <div class="row mt-4">
            <div class="col-md-6">
              <p>
                <strong>Priority:</strong>
                <span :class="priorityClass" class=" ms-2 text-uppercase">{{ selectedTask.priority }}</span>
              </p>
            </div>
            <div class="col-md-6">
              <p>
                <strong>Status:</strong>
                <span :class="statusClass" class=" ms-2 text-uppercase">{{ selectedTask.status }}</span>
              </p>
            </div>
          </div>
          <p><strong>Deadline:</strong> {{ formattedDeadline }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import taskService from "../../service/task_service";

export default {
  props: ["taskId"],
  setup(props) {
    const selectedTask = ref({});
    const { success, getTask, task } = taskService();
    const isLoading = ref(false);

    onMounted(async () => {
      await fetchTaskDetail(props.taskId);
    });

    const fetchTaskDetail = async (id) => {
      isLoading.value = true;
      await getTask(id).then(() => {
        if (success.value) {
          selectedTask.value = task.value;
          console.log("data", selectedTask.value)
        }
        isLoading.value = false;
      });
    };

    const formattedDeadline = computed(() => {
      if (selectedTask.value?.deadline) {
        const options = { year: "numeric", month: "long", day: "numeric" };
        return new Date(selectedTask.value.deadline).toLocaleDateString(
          undefined,
          options
        );
      }
      return "No deadline set";
    });

    const priorityClass = computed(() => {
      switch (selectedTask.value.priority) {
        case "height":
          return "text-danger";
        case "medium":
          return "text-warning";
        case "low":
          return "text-success";
        default:
          return "";
      }
    });

    const statusClass = computed(() => {
      switch (selectedTask.value.status) {
        case "ended":
          return "text-success";
        case "in_progress":
          return "text-primary";
        case "pending":
          return "text-secondary";
        default:
          return "";
      }
    });

    return {
      fetchTaskDetail,
      formattedDeadline,
      selectedTask,
      isLoading,
      priorityClass,
      statusClass,
    };
  },
};
</script>


<style scoped>
@import "../../assets/css//tasks.css";
</style>