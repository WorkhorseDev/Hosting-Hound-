<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/Auth/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    phone_number: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout heading="Welcome" subheading="Create your free account" >
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div class="input-wrap">
                <InputLabel for="name" value="Name" class="sr-only" />

                <i class="input-icon far fa-user"></i>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Full Name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="input-wrap mt-8">
                <InputLabel for="email" value="Email" class="sr-only" />

                <i class="input-icon far fa-envelope"></i>
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    placeholder="Email Address"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="input-wrap mt-8">
                <InputLabel for="password" value="Password" class="sr-only" />

                <i class="input-icon fas fa-phone"></i>
                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone_number"
                    required
                    autocomplete="phone"
                    placeholder="Phone Number"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="input-wrap mt-8">
                <InputLabel for="password" value="Password" class="sr-only" />

                <i class="input-icon fas fa-lock"></i>
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="Create Password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="input-wrap mt-8 mb-16">
                <InputLabel for="password_confirmation" value="Confirm Password" class="sr-only" />

                <i class="input-icon fas fa-key"></i>
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm Password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex flex-col items-center justify-end mt-4">

                <button class="btn-primary mb-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Sign Up
                </button>

                <Link
                    :href="route('login')"
                    class="btn-primary"
                >
                    Return to Login
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
