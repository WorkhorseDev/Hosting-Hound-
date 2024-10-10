<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';;
import TextInput from '@/Components/Auth/TextInput.vue';
import {Link, useForm} from '@inertiajs/vue3';
import InputError from "@/Components/InputError.vue";

defineProps({
  email: String,
  status: {
    type: String,
    email: String,
  },
});

const form = useForm({
  code: '',
});


const submit = () => {
  form.post(route('verifyStore'));
};

</script>

<template>
  <GuestLayout
      heading="Enter Your Code"
      subheading="Please enter the six digit verification code sent to"
      :showLogo="false"
      :heading-email=email
  >
    <form @submit.prevent="submit">
      <InputError class="mt-2 accent-green-800" :message="form.errors.code_send" />
      <div class="input-wrap">
        <InputLabel for="code" value="Code" class="sr-only" />

        <i class="input-icon fas fa-lock"></i>
        <TextInput
            id="code"
            type="code"
            class="mt-1 block w-full"
            v-model="form.code"
            required
            placeholder="New Code"
        />
      </div>
      <InputError class="mt-2" :message="form.errors.two_factor_code" />
      <div class="flex items-center justify-center mt-10">
        <button class="btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
         Continue
        </button>
      </div>
      <div  class="flex items-center justify-center mt-10">
        <Link
            :href="route('verifyResend')"
            class="link-item check-label"
        >
         Didn't get the code?
        </Link>
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
