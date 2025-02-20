<template>
    <AuthenticatedLayout>
      <div>
        <h1 class="tracking-tight text-balance text-gray-900 sm:text-xl">Manage Course Outcome</h1>
      </div>
      <div class="py-4">
        <!-- Render CourseOutcomeTable when there is no ID in the route -->
        <!-- <CourseOutcomeTable v-if="!$route.params.id" :course_outcome="course_outcome" />

        <LearningOutcomestable v-else :id="1" /> -->
        <RouterView :course_outcome="course_outcome" />
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import CourseOutcomeTable from '@/Components/app/CourseOutcomeTable.vue';
  import LearningOutcomestable from '@/Components/app/LearningOutcomestable.vue';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { onMounted, ref } from 'vue';
  import axios from 'axios';
  import { RouterView } from "vue-router"; // ✅ Import RouterView
  const course_outcome = ref([]);

  onMounted(async () => {
    try {
      const response = await axios.get('/course-outcome');
      course_outcome.value = response.data;
      console.log("Fetched Data:", course_outcome.value);
    } catch (error) {
      console.error("Error fetching course outcomes:", error);
    }
  });
  </script>

  <style scoped>
  /* Add styles here if necessary */
  </style>
