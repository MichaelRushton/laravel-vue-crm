<template>
    <WhenVisible
        always
        v-if="data.meta.next_cursor"
        :key="data.meta.next_cursor"
        :params="{
            data: {
                cursor: data.meta.next_cursor,
            },
            only: only,
            preserveUrl: true,
        }"
    >
        <template #fallback>
            <div class="p-4">Loading...</div>
        </template>
    </WhenVisible>
</template>

<script setup>
import { WhenVisible } from "@inertiajs/vue3";

defineProps({
    data: Object,
    only: Array,
});
</script>
