<template>
  <Modal :show="modelValue" max-width="sm" @show="onShow">
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

<script>
import { FloatLabel, InputText, Textarea } from 'primevue';
import InputLabel from '../InputLabel.vue';
import Modal from '../Modal.vue';
import InputError from '../InputError.vue';
import SecondaryButton from '../SecondaryButton.vue';
import PrimaryButton from '../PrimaryButton.vue';

export default {

}
</script>

<style>

</style>
