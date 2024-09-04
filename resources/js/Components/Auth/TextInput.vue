<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="auth-input"
        v-model="model"
        ref="input"
    />
</template>

<style scoped>
.auth-input {
    width: 470px;
    font-size: 32px;
    border-radius: 38px;
    line-height: 1.5em;
    padding: 10px 15px 10px 75px;
    -webkit-box-shadow: 8px 0px 12px -9px rgba(0, 0, 0, 0.5);
    -moz-box-shadow: 8px 0px 12px -9px rgba(0, 0, 0, 0.5);
    box-shadow: 0px 8px 12px -9px rgba(0, 0, 0, 0.5);
}

.auth-input::placeholder {
    color: #959595;
}
</style>
