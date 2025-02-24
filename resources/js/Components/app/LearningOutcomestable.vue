<template>
    <div>
      <DataTable
        :value="learning_objectives"
        selectionMode="single"
        dataKey="id"
        ref="dt"
        :paginator="true"
        :rows="10"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        :rowsPerPageOptions="[5, 10, 25]"
        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} learning objectives"
      >
        <template #header>
          <div class="flex flex-wrap gap-2 items-center justify-between">
            <Breadcrumb :home="home" :model="items" />
          </div>
        </template>

        <!-- Subject Column -->
        <Column field="subject.subject" header="Subject" sortable style="min-width: 12rem">
          <template #body="slotProps">
            <span v-if="slotProps.data.subject">
              {{ slotProps.data.subject.subject || 'N/A' }}
            </span>
            <Skeleton v-else width="80%" height="20px" />
          </template>
        </Column>

        <!-- Course Outcome Column -->
        <Column field="props.course_outcome_code" header="Course Outcome" sortable style="min-width: 12rem">
          <template #body="">
            <span v-if="props.course_outcome_code">
              {{ props.course_outcome_code || 'N/A' }}
            </span>
            <Skeleton v-else width="80%" height="20px" />
          </template>
        </Column>

        <!-- Learning Objective Code -->
        <Column field="learning_objectives_code" header="Learning Objective Code" sortable style="min-width: 16rem">
          <template #body="slotProps">
            <Skeleton v-if="loading" width="80%" height="20px" />
            <span v-else>{{ slotProps.data.learning_objectives_code }}</span>
          </template>
        </Column>

        <!-- Status Column -->
        <Column field="status" header="Status" sortable style="min-width: 10rem">
          <template #body="slotProps">
            <Skeleton v-if="loading" width="50%" height="20px" />
            <Tag v-else :value="slotProps.data.status === 1 ? 'Active' : 'Inactive'" :severity="getStatusLabel(slotProps.data.status)" />
          </template>
        </Column>

        <!-- Action Buttons -->
        <Column header="Action" :exportable="false" style="min-width: 8rem">
          <template #body="slotProps">
            <Skeleton v-if="loading" width="40px" height="20px" />
            <Button v-else icon="pi pi-eye" outlined rounded class="mr-2" @click="viewDetails(slotProps.data)" />
          </template>
        </Column>
      </DataTable>
    </div>
  </template>

  <script setup>
  import { ref, defineProps, watchEffect, defineEmits } from "vue";
  import axios from "axios";
  import { Breadcrumb, Column, DataTable, Tag, Skeleton, Button } from "primevue";

  const emit = defineEmits(["goBack"]);
  const props = defineProps({
    id: Number,
    course_outcome_code: String,
  });

  const learning_objectives = ref([]); // Corrected variable name
  const loading = ref(true);

  // ✅ Fetch learning objectives based on course outcome ID
  watchEffect(async () => {
    if (props.id) {
      loading.value = true;
      try {
        const response = await axios.get(`/learning-objectives/${props.id}`);
        learning_objectives.value = response.data.learning_objective;
      } catch (error) {
        console.error("Error fetching learning objectives:", error);
      } finally {
        loading.value = false;
      }
    }
  });

  // Breadcrumb Navigation
  const goBack = () => {
    emit("goBack");
  };

  const home = ref({ icon: "pi pi-home", label: "Home" });
  const items = ref([{ icon: "pi pi-folder", label: "Course Outcomes", command: goBack }]);

  watchEffect(() => {
    if (props.course_outcome_code) {
      items.value = [
        { icon: "pi pi-folder", label: "Course Outcomes", command: goBack },
        { icon: "pi pi-book", label: props.course_outcome_code },
      ];
    }
  });

  function getStatusLabel(status) {
    return status === 1 ? "success" : "danger";
  }

  const viewDetails = (rowData) => {
    console.log("Viewing details for:", rowData);
  };
  </script>
