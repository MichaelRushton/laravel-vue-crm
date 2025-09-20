<template>
    <LinkButton class="bg-red-500 text-white hover:!bg-red-600">
        <slot />
    </LinkButton>
</template>

<script setup>
import LinkButton from "./LinkButton.vue";
</script>
