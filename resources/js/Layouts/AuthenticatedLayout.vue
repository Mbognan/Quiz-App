

<template>
    <div class="h-screen bg-gray-50 flex w-full gap-4">

        <Navigation />

      <main class="flex flex-col flex-1 px-4 overflow-hidden">
        <div class=" overflow-y-auto">
        <div class="flex items-center justify-between w-full">
            <FormSearch />
            <UserSetting />
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <slot />
        </div>
    </div>
      </main>
    </div>


</template>

<script setup>
import FormSearch from '@/Components/app/FormSearch.vue';
import Navigation from '@/Components/app/Navigation.vue';
import UserSetting from '@/Components/app/UserSetting.vue';
import { ref } from 'vue';


const showingNavigationDropdown = ref(false);
</script>
