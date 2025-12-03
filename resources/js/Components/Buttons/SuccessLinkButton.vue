resources/js/Components/Buttons/PrimaryLinkButton.vue
<template>
    <LinkButton class="bg-success-500 hover:bg-success-600! text-white">
        <slot />
    </LinkButton>
</template>

<script setup>
import LinkButton from "./LinkButton.vue";
</script>
