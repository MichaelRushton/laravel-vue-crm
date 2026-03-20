<template>
    <div class="flex">
        <Input
            type="text"
            class="w-full rounded-r-none"
            :placeholder="placeholder"
            v-model="model"
            @keyup.enter="search"
        />
        <InputAppend
            class="cursor-pointer hover:bg-neutral-100"
            title="Search"
            @click="search"
        >
            <MagnifyingGlassIcon class="size-6" />
        </InputAppend>
    </div>
</template>

<script setup>
import Input from "./Input.vue";
import { MagnifyingGlassIcon } from "@heroicons/vue/24/outline";
import InputAppend from "./Input/InputAppend.vue";

const model = defineModel();

defineProps({
    search: Function,
    placeholder: {
        type: String,
        default: "Search...",
    },
});
</script>
