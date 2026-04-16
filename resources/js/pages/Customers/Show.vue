<template>
    <Modal v-if="customer" @close-modal="customer = null" class="gap-4 p-4">
        <div class="flex">
            <b>{{ customer.first_name }} {{ customer.last_name }}</b>
            <XMarkIcon
                class="ml-auto size-6 cursor-pointer"
                @click="customer = null"
            />
        </div>
        <div>{{ customer.email }}</div>
        <div class="flex justify-end">
            <SuccessLinkButton :href="`/customers/${customer.uuid}/edit`">
                Edit
            </SuccessLinkButton>
        </div>
    </Modal>
</template>

<script setup>
import SuccessLinkButton from "@/components/Buttons/SuccessLinkButton.vue";
import Modal from "@/components/Modal/Modal.vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";

const customer = defineModel();
</script>
