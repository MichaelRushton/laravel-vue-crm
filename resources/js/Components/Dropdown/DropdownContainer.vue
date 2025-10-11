<template>
    <div class="relative" @click="open = !open">
        <slot name="toggle" />
        <div v-if="open" class="relative">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const open = ref(false);
</script>
