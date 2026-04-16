<template>
    <NeutralButton class="flex items-center gap-2" title="Reset">
        <BackspaceIcon class="size-6" />
        <span class="hidden sm:inline">Reset</span>
    </NeutralButton>
</template>

<script setup>
import { BackspaceIcon } from "@heroicons/vue/24/outline";
import NeutralButton from "../Buttons/NeutralButton.vue";
</script>
