<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/Auth/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

defineProps({
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
        heading="Reset Password"
        subheading="To reset your password, please enter the email associated with your account."
        :showLogo="false"
    >
        <Head title="Forgot Password" />

<!--        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.
        </div>-->

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
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
                <button class="btn-primary" :disabled="form.processing">
                    Send
                </button>
            </div>
          <div class="flex items-center justify-center mt-10">
          <Link
              :href="route('re-send')"
              class="link-item check-label"
          >
            Resend email?
          </Link>
          </div>
        </form>
    </GuestLayout>
</template>
