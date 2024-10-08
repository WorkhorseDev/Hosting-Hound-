<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/Auth/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
  token: {
    type: String,
    required: true,
  },
});

const form = useForm({
  token: props.token,
  code: '',
});

const submit = () => {
  form.post(route('verify.store'), {

  });
};
</script>

<template>
  <GuestLayout
      heading="Enter Your Code"
      subheading="Please enter the six digit verification code sent to " + {{email}}
      :showLogo="false"
  >

    <form @submit.prevent="submit">

      <div class="input-wrap">
        <InputLabel for="code" value="Code" class="sr-only" />

        <i class="input-icon fas fa-lock"></i>
        <TextInput
            id="code"
            type="code"
            class="mt-1 block w-full"
            v-model="form.code"
            required
            autocomplete="new-password"
            placeholder="New Code"
        />

      </div>


      <div class="flex items-center justify-center mt-10">
        <button class="btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
         Continue
        </button>
      </div>
    </form>
  </GuestLayout>
</template>
<script>
export default {
  props: {
    email: String,
  }
}

</script>
