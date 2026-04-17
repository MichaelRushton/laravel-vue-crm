<template>
    <div class="flex">
        <Input
            :type="show ? 'text' : 'password'"
            :id
            class="w-full rounded-r-none"
            v-model="model"
            :required
            :minlength
        />
        <InputAppend
            class="cursor-pointer hover:bg-neutral-100"
            :title="`${show ? 'Hide' : 'Show'} password`"
            @click="show = !show"
        >
            <EyeSlashIcon v-if="!show" class="size-6" />
            <EyeIcon v-else class="size-6" />
        </InputAppend>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Input from "./Input.vue";
import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/solid";
import InputAppend from "./Input/InputAppend.vue";

defineProps({
    id: String,
    required: Boolean,
    minlength: Number,
});

const model = defineModel();

const show = ref(false);
</script>
