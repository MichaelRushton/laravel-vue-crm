<template>
    <dialog
        class="m-auto flex flex-col rounded border border-neutral-400 bg-white sm:w-xl"
        @vue:mounted="(e) => e.el.showModal()"
        @close="$emit('closeModal')"
    >
        <slot />
    </dialog>
</template>

<script setup></script>
