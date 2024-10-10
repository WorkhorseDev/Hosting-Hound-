<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/Auth/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout heading="Hosting Hound" subheading="Welcome, we’re glad you’re here!">
        <Head title="Log in" />

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

            <div class="input-wrap mt-9">
                <InputLabel for="password" value="Password" class="sr-only" />

                <i class="input-icon fas fa-lock"></i>
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="Password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

<!--            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>-->

            <div class="flex flex-col items-center justify-center mt-16">
                <button class="mb-8 btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Sign in
                </button>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-2xl text-white hover:no-underline"
                >
                    Forgot your password?
                </Link>
            </div>
          <div class="flex flex-col items-center justify-center mt-16">
              <Link
                  :href="route('register')"
                  class="mb-8 btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
              >
                Sign up
              </Link>
            </div>
        </form>
    </GuestLayout>
</template>
