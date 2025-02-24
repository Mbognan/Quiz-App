<template>
    <AuthenticatedLayout>
      <div>
        <h1 class="tracking-tight text-gray-900 sm:text-xl">
          Manage Course Outcome
        </h1>
      </div>
      <div class="py-4">
        <CourseOutcomeTable
          v-if="!selectedCourse"
          :course_outcome="course_outcome"
          @row-dblclick="handleRowClick"
        />
        <LearningOutcomestable
          v-else
          :id="selectedCourse.id"
          :course_outcome_code="selectedCourse.course_outcomes_code"
          :learning_objective="learning_objective"
          @goBack="handleGoBack"
        />
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { ref, onMounted } from "vue";
  import axios from "axios";
  import CourseOutcomeTable from "@/Components/app/CourseOutcomeTable.vue";
  import LearningOutcomestable from "@/Components/app/LearningOutcomestable.vue";
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

  const course_outcome = ref([]);
  const learning_objective = ref([]);
  const selectedCourse = ref(null);

  // Fetch Course Outcome Data on page load
  onMounted(async () => {
    try {
      const response = await axios.get("/course-outcome");
      course_outcome.value = response.data;
    } catch (error) {
      console.error("Error fetching course outcomes:", error);
    }
  });

  // Handle row double-click to select course and fetch learning objectives
  const handleRowClick = async (course) => {
    if (course && course.id) {
      selectedCourse.value = {
        id: course.id,
        course_outcomes_code: course.course_outcomes_code,
      };

      console.log("Selected Course:", selectedCourse.value); // ✅ Debugging

      try {
        const response = await axios.get(`/learning-objectives/${course.id}`);
        learning_objective.value = response.data.learning_objectives;
      } catch (error) {
        console.error("Error fetching learning objectives:", error);
      }
    }
  };

  // Handle going back to Course Outcome Table
  const handleGoBack = () => {
    selectedCourse.value = null;
    learning_objective.value = []; // Reset learning objectives
  };
  </script>
