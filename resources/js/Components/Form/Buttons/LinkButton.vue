<template>
    <Link
        class="inline-block min-w-16 cursor-pointer rounded px-3 py-1.5 text-center font-semibold"
    >
        <slot />
    </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>
