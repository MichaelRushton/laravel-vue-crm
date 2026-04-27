<template>
    <Modal v-if="user" @close-modal="user = null" class="gap-4 p-4">
        <div class="flex">
            <b>{{ user.first_name }} {{ user.last_name }}</b>
            <XMarkIcon
                class="ml-auto size-6 cursor-pointer"
                @click="user = null"
            />
        </div>
        <div>{{ user.email }}</div>
        <div>{{ user.role }}</div>
        <div>{{ user.status }}</div>
        <div class="flex justify-end">
            <SuccessLinkButton :href="`/users/${user.uuid}/edit`">
                Edit
            </SuccessLinkButton>
        </div>
    </Modal>
</template>

<script setup>
import SuccessLinkButton from "@/components/Buttons/SuccessLinkButton.vue";
import Modal from "@/components/Modal/Modal.vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";

const user = defineModel();
</script>
