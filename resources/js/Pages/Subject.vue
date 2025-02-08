<template>
    <AuthenticatedLayout>
      <div>
        <h1 class="tracking-tight text-balance text-gray-900 sm:text-xl">Manage Subjects</h1>
      </div>

      <div class="py-4">
        <!-- Pass subjects to the child component and listen for new-subject-added event -->
        <SubjectTable :subjects="subjects" @new-subject-added="handleNewSubject"  />
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
    import { Inertia } from '@inertiajs/inertia'; // Correct import
  import SubjectTable from '@/Components/app/SubjectTable.vue';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { ref } from 'vue';
  import { usePage } from '@inertiajs/vue3';

  // Access props from Inertia
  const { props } = usePage();

  // Use `ref` to ensure reactivity
  const subjects = ref(props.subject);

  // Handle new subject being added


  function handleNewSubject(newSubject) {

  subjects.value.push(newSubject);
}
  </script>

  <style scoped>
  /* Add any additional styling here */
  </style>
