<template>
    <dialog
        class="m-auto rounded border border-neutral-400 bg-white sm:w-xl"
        @vue:mounted="(e) => e.el.showModal()"
        @close="$emit('closeModal')"
    >
        <div
            v-if="$slots.header"
            class="flex items-center border-b border-neutral-400 p-4 text-xl"
        >
            <slot name="header" />
            <div
                class="ml-auto cursor-pointer text-xs"
                @click="$emit('closeModal')"
            >
                Close
            </div>
        </div>
        <div class="p-4">
            <slot />
        </div>
        <div v-if="$slots.buttons" class="flex justify-end gap-4 px-4 pb-4">
            <slot name="buttons" />
        </div>
    </dialog>
</template>

<script setup></script>
