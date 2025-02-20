import { createRouter, createWebHistory } from 'vue-router';
import { defineAsyncComponent } from 'vue';

// ✅ Dynamically Import Components to Fix Refresh Issue
const CourseOutcomeTable = defineAsyncComponent(() =>
  import('@/Components/app/CourseOutcomeTable.vue')
);
const LearningOutcomestable = defineAsyncComponent(() =>
  import('@/Components/app/LearningOutcomestable.vue')
);

const routes = [
  {
    path: '/course-outcome',
    name: 'course-outcome',
    component: CourseOutcomeTable,
    props: (route) => {
      return {
        course_outcome: route.query.data ? JSON.parse(route.query.data) : [] // ✅ Fix JSON Parsing
      };
    }
  },
  {
    path: '/course-learning-outcomes/:id',
    name: 'course-learning-outcome.index',
    component: LearningOutcomestable
  },
  {
    path: "/:pathMatch(.*)*",
    redirect: "/course-outcome" // ✅ Fix redirect path
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
