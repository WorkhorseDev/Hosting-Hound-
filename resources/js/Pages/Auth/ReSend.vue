<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/Auth/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

defineProps({
  reSend: false,
  status: {
    type: String,
  },
});

const form = useForm({
  email: '',
});

const submit = () => {
  form.post(route('password.email'));
};
</script>

<template>
  <GuestLayout
      heading="Resend Email"
      subheading="psst… make sure you check your spam folder to ensure our message isn’t hiding in there!"
      :showLogo="false"
  >
<!--    <Head title="Forgot Password" />-->

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <p v-if="reSend" class="re-send">Another reset email has been sent.</p>
      <div class="input-wrap">
        <InputLabel for="email" value="Email" class="sr-only" />

        <i class="input-icon far fa-envelope"></i>
        <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
            placeholder="Email"
        />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="flex items-center justify-center mt-10">
        <button class="btn-primary" :disabled="form.processing" @click="showMe = true">
          Send Again
        </button>
      </div>
    </form>
  </GuestLayout>
</template>
<script>
export default {
  props: {
    reSend: false,
  }
}
</script>
