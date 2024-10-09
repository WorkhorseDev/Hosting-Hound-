<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import Heading from "@/Components/Auth/Heading.vue";
import Subheading from "@/Components/Auth/Subheading.vue";


defineProps({
    heading: {
        type: String,
    },
    subheading: {
        type: String,
    },
    showLogo: {
        type: Boolean,
        default: true
    },
   headingEmail: {
      type: String
   }
});

</script>

<template>
    <div class="auth-layout min-h-screen flex flex-row justify-center items-center">
        <div class="welcome-block flex flex-col items-center ">
            <div v-if="showLogo" class="logo">
                <ApplicationLogo />
            </div>
            <Heading :text="heading" />
            <Subheading :text="subheading" />
            <p>{{headingEmail}}</p>
        </div>

        <div class="second-block">
            <slot />
        </div>
    </div>
</template>

