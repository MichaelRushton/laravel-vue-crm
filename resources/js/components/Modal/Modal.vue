<template>
    <dialog
        class="border-neutral-default m-auto flex w-full flex-col rounded border bg-white sm:w-xl"
        @vue:mounted="(e) => e.el.showModal()"
        @close="$emit('closeModal')"
    >
        <div class="flex gap-4">
            <slot name="header" />
            <XMarkIcon
                class="ml-auto size-6 cursor-pointer"
                @click="$emit('closeModal')"
            />
        </div>
        <slot />
    </dialog>
</template>

<script setup>
import { XMarkIcon } from "@heroicons/vue/24/outline";
</script>
