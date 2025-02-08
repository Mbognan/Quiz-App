<template>
      <modal :show="modelValue" max-width="sm" @show="onShow">
       <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Add New Subjects
        </h2>
        <div class="mt-6">
            <InputLabel class="pt-3" id="Subject"  value="Subject" />
            <TextInput type="text"  ref="subjectInput" id="subject" v-model="form.subject"  class="mt-1 block w-full"
             :class="form.subject ? 'border-primary-500 focus:border-primary-500 focus:ring-primary-500' : ''"
            placeholder="Subject"   @keyup.enter="form.subject_code && form.subject_descriptive ? createSubject() : null" />
            <InputLabel class="pt-3" id="SubjectCode"  value="Subject Code" />
            <TextInput type="text"  ref="subjectInput" id="subjectCode" v-model="form.subject_code"  class="mt-1 block w-full"
            :class="form.subject_code ? 'border-primary-500 focus:border-primary-500 focus:ring-primary-500' : ''"
            placeholder="Subject Code"   @keyup.enter="form.subject_code && form.subject_descriptive ? createSubject() : null" />
            <InputLabel class="pt-3" id="SubjectdDescriptive"  value="Subject Descriptive" />
            <TextInput type="text"  ref="subjectDescriptive" id="subjectDescriptive" v-model="form.subject_descriptive"  class="mt-1 block w-full"
             :class="form.subject_descriptive ? 'border-primary-500 focus:border-primary-500 focus:ring-primary-500' : ''"
            placeholder="Subject Descriptive"   @keyup.enter="form.subject_code && form.subject_descriptive ? createSubject() : null" />


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
import { nextTick, ref } from 'vue';
import { Toast, useToast } from 'primevue';
import { showToast } from '@/utils/toast';
import { defineEmits } from 'vue';
const form = useForm({
    subject_code : '',
    subject_descriptive: '',
    subject: '',
    status: 1,
})
const subjectInput = ref(null);


const subjectCode = ref(null);
const emit = defineEmits(['update:modelValue'])

const {modelValue} = defineProps({
    modelValue: Boolean
})


function onShow(){
   nextTick(() => subjectCode.value.focus());
}

const toast = useToast(); // ✅ Ensure useToast is called

function createSubject() {
    form.post(route('create.subject'), {
        preserveScroll: true,
        onSuccess: (response) => {

            closeModal();
            form.reset();

            // ✅ Show PrimeVue toast
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Subject created successfully!',
                life: 3000
            });

            const newSubject = response.props.subject; // Adjust based on your API response
            emit('subject-create', newSubject); // Emit to SubjectTable
        },
        onError: (errors) => {

            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Failed to create subject',
                life: 3000
            });

            subjectInput.value.focus();
        }
    });
}


function closeModal(){
    emit('update:modelValue')
    form.clearErrors();
    form.reset();
}
function handleSubjectCreated(newSubject) {
  emit('subject-created', newSubject);  // Emit the event with the new subject
  // Optionally close the modal if you have logic to do so
}

</script>

<style>

</style>
