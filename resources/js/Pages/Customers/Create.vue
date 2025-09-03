<template>
    <Head>
        <title>
            Create customer -
            {{ $page.props.app_name }}
        </title>
    </Head>
    <Form class="p-4 sm:w-96" @submit.prevent="form.post('/customers')">
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
    </Form>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import Form from "../../Components/Form/Form.vue";
import InputGroup from "../../Components/Form/Inputs/InputGroup.vue";
import Input from "../../Components/Form/Inputs/Input.vue";
import DangerFeedback from "../../Components/Form/Feedback/DangerFeedback.vue";
import ButtonGroup from "../../Components/Form/Buttons/ButtonGroup.vue";
import BackButton from "../../Components/Form/Buttons/BackButton.vue";
import PrimaryButton from "../../Components/Form/Buttons/PrimaryButton.vue";

const form = useForm({
    first_name: null,
    last_name: null,
    email: null,
});
</script>
