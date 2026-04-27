<template>
    <Modal v-if="user" @close-modal="user = null" class="gap-4 p-4">
        <template #header>
            <b>{{ user.first_name }} {{ user.last_name }}</b>
        </template>
        <div>{{ user.email }}</div>
        <div>{{ user.role }}</div>
        <div
            :class="{
                'text-success-600': 'Active' === user.status,
                'text-danger-600': 'Inactive' === user.status,
            }"
        >
            {{ user.status }}
        </div>
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

const user = defineModel();
</script>
