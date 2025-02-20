<template>
    <div>
      <h2 >Learning Outcomes for Course Outcome ID: {{ route.params.id }}</h2>


    </div>
  </template>

  <script setup>
  import { ref, watchEffect } from "vue";
  import { useRoute } from "vue-router";
  import axios from "axios";

  const route = useRoute();
  const learningObjectives = ref([]);

  // Watch for route changes and fetch data only if `id` is available
  watchEffect(() => {
    if (route.params.id) {
      axios.get(`/course-learning-outcomes/${route.params.id}`)
        .then(response => {
          learningObjectives.value = response.data.learning_objectives;
        })
        .catch(error => {
          console.error("Error fetching learning outcomes:", error);
        });
    }
  });
  </script>

  <style scoped>
  /* Add any styles you want here */
  </style>
