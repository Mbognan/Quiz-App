<template>
    <AuthenticatedLayout>
      <div>
        <h1 class="tracking-tight text-balance text-gray-900 sm:text-xl">Manage Subjects</h1>
      </div>

      <div class="py-4">
        <!-- Pass subjects to the child component and listen for new-subject-added event -->
        <SubjectTable :subjects="subjects" @subject-created="handleNewSubject" />
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

  const subjects = ref(props.subject);

  console.log(subjects);

  function handleNewSubject(newSubject) {
    subjects.value.push(newSubject);  // This should trigger reactivity, but we'll use nextTick to ensure DOM is updated
  nextTick(() => {
    console.log('New subject added, DOM should be updated now');
  });
}
  </script>

  <style scoped>
  /* Add any additional styling here */
  </style>
