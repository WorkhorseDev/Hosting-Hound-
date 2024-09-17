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
    verificationCode: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout
        heading="Enter Your Code"
        subheading="Please enter the six digit verification code sent to email@gmail.com."
        :showLogo="false"
    >
        <Head title="Enter Your Code" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div class="input-wrap">
                <InputLabel for="verificationCode" value="verificationCode" class="sr-only" />

                <i class="input-icon fas fa-lock"></i>
                <TextInput
                    id="verificationCode"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.verificationCode"
                    required
                    autofocus
                    autocomplete="verificationCode"
                    placeholder="Enter code"
                />

                <InputError class="mt-2" :message="form.errors.verificationCode" />
            </div>

            <div class="flex flex-col items-center justify-center mt-10">
                <button class="btn-primary mb-8" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Continue
                </button>

                <Link
                    :href="route('password.request')"
                    class="underline text-2xl text-white hover:no-underline"
                >
                    Didn't get the code?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
