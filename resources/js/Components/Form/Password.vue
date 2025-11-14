<template>
    <div class="flex">
        <Input
            :type="show ? 'text' : 'password'"
            class="w-full rounded-r-none"
            v-model="model"
            :required
            :minlength
        />
        <div
            class="cursor-pointer rounded-r border-y border-r border-neutral-400 p-2 hover:bg-neutral-100"
            :title="`${show ? 'Hide' : 'Show'} password`"
            @click="show = !show"
        >
            <EyeSlashIcon v-if="!show" class="size-6" />
            <EyeIcon v-else class="size-6" />
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Input from "./Input.vue";
import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/solid";

defineProps({
    required: Boolean,
    minlength: Number,
});

const model = defineModel();

const show = ref(false);
</script>
