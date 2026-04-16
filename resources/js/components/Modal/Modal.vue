<template>
    <dialog
        class="border-neutral-default m-auto flex w-full flex-col rounded border bg-white sm:w-xl"
        @vue:mounted="(e) => e.el.showModal()"
        @close="$emit('closeModal')"
    >
        <slot />
    </dialog>
</template>

<script setup></script>
