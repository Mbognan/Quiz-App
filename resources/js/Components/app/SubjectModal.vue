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
                <PrimaryButton   class="ml-3"   :disabled="form.processing" @click="submitForm" >
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
import InputError from '../InputError.vue';
import SecondaryButton from '../SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '../PrimaryButton.vue';
import { nextTick, reactive, ref, watch, defineProps, defineEmits } from 'vue';
import { FloatLabel, useToast } from 'primevue';
import axios from 'axios';
import Textarea from 'primevue/textarea';
import InputText from 'primevue/inputtext';
import { Inertia } from '@inertiajs/inertia';
const toast = useToast();
const emit = defineEmits(['update:modelValue', 'subject-create', 'subject-updated']);

const props = defineProps({
    modelValue: Boolean,
    subject: Object
});

const form = reactive({
    id: null,
    subject_code: '',
    subject: '',
    subject_descriptive: '',
    status: 1,
    errors: {}
});

// Autofill form when editing
watch(() => props.subject, (newSubject) => {
    if (newSubject) {
        form.id = newSubject.id;
        form.subject_code = newSubject.subject_code;
        form.subject = newSubject.subject;
        form.subject_descriptive = newSubject.subject_descriptive;
        form.status = newSubject.status;
    } else {
        resetForm();
    }
}, { immediate: true });

async function submitForm(event) {
    event.preventDefault();
    try {
        if (form.id) {
            // Send update request via Axios
            const response = await axios.put(route('update.subject', form.id), form, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            });
            emit('subject-updated', response.data.subject);
            toast.add({
                severity: 'success',
                summary: 'Updated',
                detail: 'Subject updated successfully!',
                life: 3000
            });

            closeModal();
        } else {
            // Create a new subject
            const response = await axios.post(route('create.subject'), form);
            emit('subject-create', response.data);
            toast.add({
                severity: 'success',
                summary: 'Created',
                detail: 'Subject created successfully!',
                life: 3000
            });

            closeModal();
        }
    } catch (error) {
        console.error("AXIOS ERROR:", error); // ✅ Log the error in the console

        if (error.response) {
            console.log("ERROR RESPONSE:", error.response); // ✅ See full error details
        } else {
            console.log("ERROR MESSAGE:", error.message);
        }

        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Something went wrong. Check console.',
            life: 3000
        });
    }
}



function closeModal() {
    emit('update:modelValue', false);
    resetForm();
}

function resetForm() {
    form.id = null;
    form.subject_code = '';
    form.subject = '';
    form.subject_descriptive = '';
    form.status = 1;
    form.errors = {};
}
</script>

<style>

</style>
