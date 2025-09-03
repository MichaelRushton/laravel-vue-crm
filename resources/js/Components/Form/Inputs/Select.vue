<template>
    <select class="rounded border border-neutral-400 p-2" v-model="model">
        <option
            v-if="props.options"
            v-for="(option, key) in props.options"
            :key="key"
            :value="option.value"
        >
            {{ option.label }}
        </option>
    </select>
</template>

<script setup>
const props = defineProps({ options: Array });

const model = defineModel();
</script>
