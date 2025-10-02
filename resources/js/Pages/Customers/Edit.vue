<template>
    <Head>
        <title>
            Edit customer -
            {{ $page.props.app_name }}
        </title>
    </Head>
    <Form
        class="p-4 sm:w-96"
        @submit.prevent="form.patch(`/customers/${customer.id}`)"
    >
        <InputGroup>
            <label for="first_name">First name</label>
            <Input
                type="text"
                id="first_name"
                required
                v-model="form.first_name"
            />
            <DangerFeedback v-if="form.errors.first_name">{{
                form.errors.first_name
            }}</DangerFeedback>
        </InputGroup>
        <InputGroup>
            <label for="last_name">Last name</label>
            <Input
                type="text"
                id="last_name"
                required
                v-model="form.last_name"
            />
            <DangerFeedback v-if="form.errors.last_name">{{
                form.errors.last_name
            }}</DangerFeedback>
        </InputGroup>
        <InputGroup>
            <label for="email">Email address</label>
            <Input type="email" id="email" required v-model="form.email" />
            <DangerFeedback v-if="form.errors.email">{{
                form.errors.email
            }}</DangerFeedback>
        </InputGroup>
        <ButtonGroup class="grid-cols-2">
            <BackButton />
            <PrimaryButton type="submit" :disabled="form.processing"
                >Save</PrimaryButton
            >
        </ButtonGroup>
        <DangerButton
            v-if="customer.can_delete"
            class="mt-4 w-fit"
            @click="to_delete = true"
            >Delete</DangerButton
        >
    </Form>
    <Modal
        v-if="customer.can_delete && to_delete"
        @close-modal="to_delete = false"
    >
        <template #header>Delete</template>
        <DangerNotice class="space-y-4">
            <div>Are you sure you would like to delete this customer?</div>
            <div>
                All data associated with the customer will be
                <strong><u>temporarily</u></strong> removed for 1 week and then
                <strong><u>permanently</u></strong> removed.
            </div>
            <div>
                A permanent removal <strong><u>cannot</u></strong> be undone.
            </div>
        </DangerNotice>
        <template #buttons>
            <DefaultButton @click="to_delete = false">No</DefaultButton>
            <DangerLinkButton
                :href="`/customers/${customer.id}`"
                method="delete"
                >Yes</DangerLinkButton
            >
        </template>
    </Modal>
</template>

<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import Form from "../../Components/Form/Form.vue";
import InputGroup from "../../Components/Form/Inputs/InputGroup.vue";
import Input from "../../Components/Form/Inputs/Input.vue";
import DangerFeedback from "../../Components/Form/Feedback/DangerFeedback.vue";
import ButtonGroup from "../../Components/Buttons/ButtonGroup.vue";
import BackButton from "../../Components/Buttons/BackButton.vue";
import PrimaryButton from "../../Components/Buttons/PrimaryButton.vue";
import DangerButton from "../../Components/Buttons/DangerButton.vue";
import Modal from "../../Components/Modal/Modal.vue";
import DangerNotice from "../../Components/Notice/DangerNotice.vue";
import DefaultButton from "../../Components/Buttons/DefaultButton.vue";
import DangerLinkButton from "../../Components/Buttons/DangerLinkButton.vue";

const props = defineProps({
    customer: Object,
});

const form = useForm({
    first_name: props.customer.first_name,
    last_name: props.customer.last_name,
    email: props.customer.email,
});

const to_delete = ref(false);
</script>
