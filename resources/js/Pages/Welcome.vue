<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Heading from "@/Components/Auth/Heading.vue";
import Subheading from "@/Components/Auth/Subheading.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

</script>

<template>
    <Head title="Welcome" />

    <div class="auth-layout min-h-screen flex justify-center items-center">
        <div class="welcome-block flex flex-col items-center ">
            <div class="logo">
                <ApplicationLogo />
            </div>
            <Heading text="Hosting Hound" />
            <Subheading text="Welcome, we’re glad you’re here!"/>
        </div>

        <div class="second-block">
            <div class="links flex flex-col items-center">
                <Link
                    :href="route('login')"
                    class="btn-primary"
                >
                    Sign In
                </Link>
                <p class="divider">or</p>
                <Link
                    :href="route('register')"
                    class="btn-primary"
                >
                    Sign Up
                </Link>
            </div>
        </div>
    </div>
</template>



