<template>
    <select class="rounded border border-neutral-400 p-2" v-model="model">
        <slot />
        <option
            v-if="props.options?.length"
            v-for="(option, key) in props.options"
            :key
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
