<template>
    <Modal
        v-if="impersonate"
        @close-modal="impersonate = null"
        class="gap-4 p-4"
    >
        <div>
            Sign in as {{ impersonate.first_name }} {{ impersonate.last_name }}?
        </div>
        <div class="grid grid-cols-2 gap-4 sm:flex">
            <NeutralLinkButton @click="impersonate = null" class="sm:ml-auto">
                No
            </NeutralLinkButton>
            <PrimaryLinkButton
                :href="`/users/${impersonate.uuid}/impersonate`"
                method="post"
            >
                Yes
            </PrimaryLinkButton>
        </div>
    </Modal>
</template>

<script setup>
import Modal from "@/Components/Modal/Modal.vue";
import NeutralLinkButton from "@/Components/Buttons/NeutralLinkButton.vue";
import PrimaryLinkButton from "@/Components/Buttons/PrimaryLinkButton.vue";

const impersonate = defineModel();
</script>
