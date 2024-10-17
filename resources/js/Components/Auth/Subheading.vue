<script setup>
defineProps({
    text: {
        type: String,
    }
})
</script>

<template>
    <p class="subheading">{{ text }}</p>
</template>

<style scoped>
.subheading {
    color: #ffffff;
    font-size: 2.2rem;
    font-family: Lato;
    text-align: center;
    line-height: 1.35em;
}
@media screen and (max-width: 768px) {
    .subheading {
        font-size: 1.5rem;
        max-width: 250px;
    }
}
</style>
