<template>
    <Head>
        <title>
            {{ user ? "Edit" : "Create" }} user - {{ $page.props.app_name }}
        </title>
    </Head>
    <h1 class="text-xl">{{ user ? "Edit" : "Create" }} user</h1>
    <form
        @submit.prevent="
            user ? form.patch(`/users/${user.uuid}`) : form.post('/users')
        "
        class="mt-4"
    >
        <Card class="w-full gap-4 p-4 sm:w-96">
            <div class="flex flex-col gap-1">
                <label for="first_name">First name</label>
                <Input
                    type="text"
                    id="first_name"
                    v-model="form.first_name"
                    required
                    maxlength="255"
                />
                <DangerFeedback v-if="form.errors.first_name">{{
                    form.errors.first_name
                }}</DangerFeedback>
            </div>
            <div class="flex flex-col gap-1">
                <label for="last_name">Last name</label>
                <Input
                    type="text"
                    id="last_name"
                    v-model="form.last_name"
                    required
                    maxlength="255"
                />
                <DangerFeedback v-if="form.errors.last_name">{{
                    form.errors.last_name
                }}</DangerFeedback>
            </div>
            <div class="flex flex-col gap-1">
                <label for="email">Email address</label>
                <Input
                    type="email"
                    id="email"
                    v-model="form.email"
                    required
                    maxlength="255"
                />
                <DangerFeedback v-if="form.errors.email">{{
                    form.errors.email
                }}</DangerFeedback>
            </div>
            <div class="flex flex-col gap-1">
                <label for="role">Role</label>
                <Select
                    id="role"
                    v-model="form.role"
                    :options="roles"
                    required
                />
                <DangerFeedback v-if="form.errors.role">{{
                    form.errors.role
                }}</DangerFeedback>
            </div>
            <div class="flex flex-col gap-1">
                <label for="status">Status</label>
                <Select
                    id="status"
                    v-model="form.status"
                    :options="statuses"
                    required
                />
                <DangerFeedback v-if="form.errors.status">{{
                    form.errors.status
                }}</DangerFeedback>
            </div>
            <div class="flex flex-col gap-1">
                <label for="password">Password</label>
                <Password
                    id="password"
                    v-model="form.password"
                    :required="!user"
                    :minlength="password_min"
                />
                <DangerFeedback v-if="form.errors.password">{{
                    form.errors.password
                }}</DangerFeedback>
                <Feedback v-else>
                    The password must be at least
                    {{ password_min }} characters.
                </Feedback>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <NeutralLinkButton href="/users">Back</NeutralLinkButton>
                <PrimaryButton
                    type="submit"
                    :disabled="form.processing"
                    class="col-span-2"
                >
                    Save
                </PrimaryButton>
            </div>
        </Card>
    </form>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import Card from "../../Components/Card/Card.vue";
import Input from "../../Components/Form/Input.vue";
import DangerFeedback from "../../Components/Feedback/DangerFeedback.vue";
import Password from "../../Components/Form/Password.vue";
import Feedback from "../../Components/Feedback/Feedback.vue";
import NeutralLinkButton from "../../Components/Buttons/NeutralLinkButton.vue";
import PrimaryButton from "../../Components/Buttons/PrimaryButton.vue";
import Select from "../../Components/Form/Select.vue";

const props = defineProps({
    user: Object,
    roles: Array,
    statuses: Array,
    password_min: Number,
});

const form = useForm({
    first_name: props.user?.first_name,
    last_name: props.user?.last_name,
    email: props.user?.email,
    role: props.user?.role,
    status: props.user?.status,
    password: null,
});
</script>
