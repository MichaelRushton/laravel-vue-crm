<template>
    <div class="flex p-4">
        <Input
            type="text"
            placeholder="Search..."
            class="w-full rounded-r-none outline-0 sm:w-60"
            @keyup="search"
            v-model="form.search"
        />
        <DefaultButton class="rounded-l-none border-l-0" @click="reset"
            >Reset</DefaultButton
        >
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Input from "../Form/Inputs/Input.vue";
import DefaultButton from "../Form/Buttons/DefaultButton.vue";

const props = defineProps({
    search: String,
    url: String,
});

const form = useForm({
    search: props.search,
});

const search = () => {
    if (1 === form.search.length) {
        return;
    }

    form.get(props.url, {
        preserveState: true,
        replace: true,
    });
};

const reset = () => {
    form.search = "";

    search();
};
</script>
