<template>
    <AuthenticatedLayout>
      <div>
        <h1 class="tracking-tight text-balance text-gray-900 sm:text-xl">Manage Subjects</h1>
      </div>

      <div class="py-4">
        <!-- Pass subjects to the child component and listen for new-subject-added event -->
        <SubjectTable :subjects="subjects" @subject-created="handleNewSubject" @subject-updated="handleSubjectUpdated"  @subject-deleted="removeSubjectFromList"  />
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
    import { Inertia } from '@inertiajs/inertia'; // Correct import
  import SubjectTable from '@/Components/app/SubjectTable.vue';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { ref ,nextTick } from 'vue';
  import { usePage } from '@inertiajs/vue3';
  import axios from 'axios';

  const { props } = usePage();

  const subjects = ref([...props.subject]);

  function handleNewSubject(newSubject) {
    console.log("New Subject Added:", newSubject);

    if (newSubject && newSubject.subject) {
        subjects.value = [...subjects.value, newSubject.subject];
    } else {
        console.error("Invalid subject format:", newSubject);
    }
}
function handleSubjectUpdated(updatedSubject) {
    console.log("Subject Updated:", updatedSubject);
    Inertia.reload({ only: ['subject'], preserveScroll: true });

}

function removeSubjectFromList(deletedId) {
    subjects.value = subjects.value.filter(subject => subject.id !== deletedId);
}





  </script>


