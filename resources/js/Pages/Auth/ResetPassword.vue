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
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout
        heading="Enter New Password"
        subheading="Please create the new password that you would like to use for this account."
        :showLogo="false"
    >
        <Head title="New Password" />

        <form @submit.prevent="submit">

            <div class="input-wrap">
                <InputLabel for="password" value="Password" class="sr-only" />

                <i class="input-icon fas fa-lock"></i>
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="Password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="input-wrap mt-8">
                <InputLabel for="password_confirmation" value="Confirm Password" class="sr-only" />

                <i class="input-icon fas fa-key"></i>
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Re-enter Password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-center mt-10">
                <button class="btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save Changes
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
