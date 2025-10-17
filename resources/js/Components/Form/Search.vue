<template>
    <div class="flex">
        <Input
            type="text"
            class="w-full rounded-r-none"
            :placeholder="placeholder"
            v-model="model"
            @keyup.enter="search"
        />
        <div
            class="cursor-pointer rounded-r border-y border-r border-neutral-400 p-2 hover:bg-neutral-100"
            title="Search"
            @click="search"
        >
            <MagnifyingGlassIcon class="size-6" />
        </div>
    </div>
</template>

<script setup>
import Input from "./Input.vue";
import { MagnifyingGlassIcon } from "@heroicons/vue/24/outline";

const model = defineModel();

defineProps({
    search: Function,
    placeholder: {
        type: String,
        default: "Search...",
    },
});
</script>
