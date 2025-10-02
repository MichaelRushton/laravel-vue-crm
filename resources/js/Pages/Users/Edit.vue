<template>
    <Head>
        <title>
            {{ user ? "Edit" : "Create" }} user - {{ $page.props.app_name }}
        </title>
    </Head>
    <Form
        class="p-4 sm:w-96"
        @submit.prevent="
            user ? form.patch(`/users/${user.id}`) : form.post('/users')
        "
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
        <InputGroup>
            <label for="role">Role</label>
            <Select id="role" required v-model="form.role" :options="roles" />
            <DangerFeedback v-if="form.errors.role">{{
                form.errors.role
            }}</DangerFeedback>
        </InputGroup>
        <InputGroup>
            <label for="password">Password</label>
            <Input
                type="password"
                id="password"
                v-model="form.password"
                :required="!user"
            />
            <DangerFeedback v-if="form.errors.password">{{
                form.errors.password
            }}</DangerFeedback>
            <Feedback v-else
                >The password must be at least
                {{ password_min }} characters.</Feedback
            >
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
import Select from "../../Components/Form/Inputs/Select.vue";
import Feedback from "../../Components/Form/Feedback/Feedback.vue";
import ButtonGroup from "../../Components/Buttons/ButtonGroup.vue";
import BackButton from "../../Components/Buttons/BackButton.vue";
import PrimaryButton from "../../Components/Buttons/PrimaryButton.vue";

const props = defineProps({
    user: Object,
    roles: Array,
    password_min: Number,
});

const form = useForm({
    first_name: props.user?.first_name,
    last_name: props.user?.last_name,
    email: props.user?.email,
    role: props.user?.role,
    password: null,
});
</script>
