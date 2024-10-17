<script setup>
defineProps({
    text: {
        type: String,
    },
});
</script>

<template>
    <h1 class="heading">{{ text }}</h1>
</template>

<style scoped>
.heading {
    color: #E7E7D5;
    font-family: Lato;
    font-size: 70px;
    line-height: 1.15em;
    text-align: center;
    margin-top: 2.2rem;
    margin-bottom: 2.2rem;
}
@media screen and (max-width: 768px) {
    .heading {
        font-size: 48px;
        margin-bottom: 1rem;
    }
}
</style>
