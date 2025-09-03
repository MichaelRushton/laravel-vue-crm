<template>
    <DefaultButton @click="back">
        <slot>Back</slot>
    </DefaultButton>
</template>

<script setup>
import DefaultButton from "./DefaultButton.vue";

const back = () => window.history.back();
</script>
