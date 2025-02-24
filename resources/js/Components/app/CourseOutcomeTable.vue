<template>
    <div class="p-4 bg-white shadow-lg rounded-lg">


      <DataTable
            @row-dblclick="$emit('row-dblclick', $event.data)"
        :value="course_outcome"
        selectionMode="single"
        dataKey="id"
        ref="dt"

        :paginator="true"
        :rows="10"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        :rowsPerPageOptions="[5, 10, 25]"
        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} products"

      >
        <template #header>
          <div class="flex flex-wrap gap-2 items-center justify-between">

            <Breadcrumb :home="home" :model="items" />
            <PrimaryButton label="New" severity="info" icon="pi pi-plus" class="mr-2 "  @click="showCreateFolderModal" > New</PrimaryButton>
          </div>
        </template>

        <Column field="subject.subject" header="Subject" sortable style="min-width: 12rem">
            <template #body="slotProps">
                <span v-if="slotProps.data.subject">
                {{ slotProps.data.subject.subject || 'N/A' }}
                </span>
                <Skeleton v-else width="80%" height="20px" />
            </template>
            </Column>



        <Column field="course_outcomes_code" header="Course Outcome" sortable style="min-width: 16rem"></Column>

        <Column field="status" header="Status" sortable style="min-width: 10rem">
          <template #body="slotProps">
            <Tag :value="slotProps.data.status === 1 ? 'Active' : 'Inactive'" :severity="getStatusLabel(slotProps.data.status)" />
          </template>
        </Column>

        <Column header="Action" :exportable="false" style="min-width: 12rem">
          <template #body="">
            <Button icon="pi pi-eye" outlined rounded class="mr-2" />
          </template>
        </Column>
      </DataTable>
    </div>
  </template>

  <script setup>
  import { ref, watchEffect } from "vue";
  import { useRouter } from "vue-router";
  import { Button, Column, DataTable, Tag, Toolbar } from 'primevue';
  import { Breadcrumb } from 'primevue';
import PrimaryButton from "../PrimaryButton.vue";
import DangerButton from "../DangerButton.vue";

  const router = useRouter();
  const courseOutcome = ref([]);

  // Props received from the parent (course outcomes list)
  const props = defineProps({
    course_outcome: {
      type: Array,
      required: true,
    }
  });

  // Watch and update course outcomes
  watchEffect(() => {
    if (props.course_outcome) {
      courseOutcome.value = props.course_outcome;

    }
  });

  const home = ref({ icon: 'pi pi-home', label: 'Home' });
  const items = ref([{ icon: 'pi pi-folder', label: 'Course Outcomes' }]);


  const handleRowClick = (event) => {
  const rowData = event.data;
  if (rowData && rowData.id) {
    router.push({ name: 'course-learning-outcome.index', params: { id: rowData.id } });
  }
};

  const resetBreadcrumb = () => {
    items.value = [{ label: 'Course Outcomes' }];
  };

  function getStatusLabel(status) {
    return status === 1 ? 'success' : 'danger';
  }
  </script>
