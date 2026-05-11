<template>
    <Teleport to="body">
        <dialog
            class="border-neutral-default m-auto flex w-full flex-col gap-4 rounded border bg-white p-4 sm:w-xl"
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
    </Teleport>
</template>

<script setup>
import { XMarkIcon } from "@heroicons/vue/24/outline";
</script>
