<template>
      <modal :show="modelValue" max-width="sm" @show="onShow">
       <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Add New Subjects
        </h2>
        <div class="mt-6">
            <InputLabel class="pt-3" id="SubjectCode"  value="Subject" />
            <FloatLabel variant="on">
            <InputText type="text"  ref="subjectInput" id="subject" v-model="form.subject"  class="mt-1 block w-full"
             :class="form.subject ? 'border-primary-500 focus:border-primary-500 focus:ring-primary-500' : ''"
            @keyup.enter="form.subject_code && form.subject_descriptive ? createSubject() : null" />
            <label for="on_label">Subject</label>
            </FloatLabel>
            <InputLabel class="pt-3" id="SubjectCode"  value="Subject Code" />
            <FloatLabel variant="on">
            <InputText  type="text"  ref="subjectInput" id="subjectCode" v-model="form.subject_code"  class="mt-2 block w-full"
            :class="form.subject_code ? 'border-primary-500 focus:border-primary-500 focus:ring-primary-500' : ''"
              @keyup.enter="form.subject_code && form.subject_descriptive ? createSubject() : null" />
              <label for="on_label">Subject Code</label>
            </FloatLabel>
            <InputLabel class="pt-3" id="SubjectCode"  value="Subject Code" />
            <FloatLabel variant="on">

            <Textarea type="text"  ref="subjectDescriptive" id="subjectDescriptive" v-model="form.subject_descriptive"  class="mt-2 block w-full"
             :class="form.subject_descriptive ? 'border-primary-500 focus:border-primary-500 focus:ring-primary-500' : ''"
               @keyup.enter="form.subject_code && form.subject_descriptive ? createSubject() : null" />
               <label for="in_label">Subject Descriptive</label>
          </FloatLabel>

            <InputError :message="form.errors.name" class="mt-2" />
            <div class="mt-6 flex justify-end">

                <SecondaryButton @click="closeModal" >
                    Close
                </SecondaryButton>
                <PrimaryButton   class="ml-3"   :disabled="form.processing" @click="createSubject" >
                    Submit
                </PrimaryButton>
            </div>
        </div>
       </div>
    </modal>

</template>

<script setup>
import Modal from '@/Components/Modal.vue';
import InputLabel from '../InputLabel.vue';
import TextInput from '../TextInput.vue';
import InputError from '../InputError.vue';
import SecondaryButton from '../SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '../PrimaryButton.vue';
import { nextTick, reactive, ref } from 'vue';
import { FloatLabel,  Toast, useToast } from 'primevue';
import { showToast } from '@/utils/toast';
import { defineEmits } from 'vue';
import axios from 'axios';
import Textarea from 'primevue/textarea';

import InputText from 'primevue/inputtext';

const toast = useToast();
const emit = defineEmits(['update:modelValue', 'subject-create']);

const form = reactive({
  subject_code: '',
  subject: '',
  subject_descriptive: '',
  status: 1,
  errors: {}
});
const {modelValue} = defineProps({
    modelValue: Boolean
})


function onShow(){
   nextTick(() => subjectCode.value.focus());
}

async function createSubject() {
  try {
    const response = await axios.post(route('create.subject'), form);
    const newSubject = response.data;

    emit('subject-create', newSubject); // Emit new subject to SubjectTable
    closeModal();

    toast.add({
      severity: 'success',
      summary: 'Success',
      detail: 'Subject created!',
      life: 3000
    });
  } catch (error) {
    if (error.response && error.response.status === 422) {
      form.errors = error.response.data.errors;
    }
    toast.add({
      severity: 'error',
      summary: 'Error',
      detail: 'Failed to create subject.',
      life: 3000
    });
  }
}

function closeModal() {
  emit('update:modelValue', false);
  form.errors = {};

  form.subject_code = '';
  form.subject_descriptive = '';
  form.subject = '';
}
</script>

<style>

</style>
