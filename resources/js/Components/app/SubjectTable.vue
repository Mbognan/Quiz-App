<template>
    <div class="p-4 bg-white shadow-lg rounded-lg">

    <Toolbar class="mb-6">
    <template #start>
        <PrimaryButton label="New" severity="info" icon="pi pi-plus" class="mr-2 "  @click="showCreateFolderModal" > New</PrimaryButton>
        <DangerButton label="Delete" icon="pi pi-trash" severity="danger" outlined @click="confirmDeleteSelected" :disabled="!selectedProducts || !selectedProducts.length" >Delete </Dangerbutton>
    </template>

    <template #end>

    </template>
</Toolbar>

<DataTable
      ref="dt"
      v-model:selection="selectedProducts"

      :value="subjects"
      dataKey="id"
      :paginator="true"

      :rows="3"
      :filters="filters"
      paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
      :rowsPerPageOptions="[3, 10, 25]"
      currentPageReportTemplate="Showing {first} to {last} of {totalRecords} products"
      :scrollable="true"
      scrollHeight="300px"
    >
    <template #header>
        <div class="flex flex-wrap gap-2 items-center justify-between">
            <h4 class="m-0">All Subjects</h4>
            <IconField>
                <InputIcon>
                    <i class="pi pi-search" />
                </InputIcon>
                <InputText   placeholder="Search..." />
            </IconField>
        </div>
    </template>
    <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
    <Column field="subject_code" header="Subject Code" sortable style="min-width: 12rem"></Column>
    <Column field="subject" header="Subject" sortable style="min-width: 10rem"></Column>
    <Column field="subject_descriptive" header="Subject Descriptive" sortable style="min-width: 16rem"></Column>
    <Column field="status" header="Status" sortable style="min-width: 10rem">
        <template #body="slotProps">

    <Tag :value="slotProps.data.status === 1 ? 'Active' : 'Inactive'"
         :severity="getStatusLabel(slotProps.data.status)" />
  </template>
    </Column>
    <Column header="Action" :exportable="false" style="min-width: 10rem">
        <template #body="slotProps">
            <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="editProduct(slotProps.data)" />
            <Button icon="pi pi-trash" outlined rounded severity="danger" @click="confirmDeleteProduct(slotProps.data)" />
        </template>
    </Column>
</DataTable>
<SubjectModal
    v-model="createFolderModal"
     :subject="selectedSubject"
    @subject-create="handleSubjectCreated"
    @subject-updated="handleSubjectUpdated"    />
<Toast />
</div>
<ConfirmDialog></ConfirmDialog>
</template>

<script setup>
import { Button, Column, ConfirmDialog, DataTable, FileUpload, IconField, InputIcon, InputText, Tag, Toast, Toolbar } from "primevue";
import SubjectModal from '@/Components/app/SubjectModal.vue';
import { useToast } from 'primevue/usetoast';
import { ref, defineProps, defineEmits, watch } from 'vue';
import PrimaryButton from '../PrimaryButton.vue';
import DangerButton from "../DangerButton.vue";
import { useConfirm } from "primevue/useconfirm";
import axios from "axios";

const emit = defineEmits(['subject-created', 'subject-updated']);
    function showCreateFolderModal(){
        createFolderModal.value = true;
    }

const confirm = useConfirm();
const createFolderModal = ref(false);
const selectedProducts = ref([]);
const filters = ref({});
const selectedSubject = ref(null);
const toast = useToast();
const props = defineProps({
  subjects: {
    type: Array,
    required: true
  }
});


function getStatusLabel(status) {
  return status === 1 ? 'success' : 'danger';
}

function handleSubjectCreated(newSubject) {
    console.log(newSubject);
  emit('subject-created', newSubject);  // Emit event to parent
}

function editProduct(subject){

    selectedSubject.value = subject;
    createFolderModal.value = true;
}



const subjectsList = ref([...props.subjects]);

watch(() => props.subjects, (newSubjects) => {
    subjectsList.value = newSubjects;
}, { deep: true }); // ✅ Reacts to deep changes

function handleSubjectUpdated(updatedSubject) {
    console.log("Emitting subject-updated event", updatedSubject);
    emit('subject-updated', updatedSubject);  // Notify parent
}


function confirmDeleteProduct(subject){
    confirm.require({
        message: `Do you want to delete this subject: ${subject.subject}`,
        header: 'Danger Zone',
        icon: 'pi pi-info-circle',
        rejectLabel: 'Cancel',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Delete',
            severity: 'danger'
        },
        accept: async () => {
            try{
                const response = await axios.delete(`subject-delete/${subject.id}`);
                toast.add({ severity: 'success', summary: 'Deleted Successfully!', detail: response.data.message, life: 3000 });
                emit('subject-deleted', subject.id);
            }  catch (error) {
                toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to delete subject', life: 3000 });
                console.error(error);
            }
        },


        // reject: () => {
        //     toast.add({ severity: 'error', summary: 'Cancel', detail: 'You have cancel the action!', life: 2000 });
        // }
    });

}



</script>
