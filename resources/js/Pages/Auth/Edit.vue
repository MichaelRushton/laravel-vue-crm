<template>
    <Head>
        <title>Update details - {{ $page.props.app_name }}</title>
    </Head>
    <h1 class="text-xl">Update details</h1>
    <SuccessNotice
        v-if="flash?.success && !form.processing"
        class="mt-4 sm:w-fit"
    >
        {{ flash.success }}
    </SuccessNotice>
    <form @submit.prevent="form.patch('/user')" class="mt-4">
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
                <label for="password">Password</label>
                <Password
                    id="password"
                    v-model="form.password"
                    :minlength="password_min"
                />
                <DangerFeedback v-if="form.errors.password">{{
                    form.errors.password
                }}</DangerFeedback>
                <Feedback v-else>
                    Your password must be at least
                    {{ password_min }} characters.
                </Feedback>
            </div>
            <PrimaryButton
                type="submit"
                :disabled="form.processing"
                class="col-span-2"
            >
                Save
            </PrimaryButton>
        </Card>
    </form>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import SuccessNotice from "../../Components/Notices/SuccessNotice.vue";
import Card from "../../Components/Card/Card.vue";
import Input from "../../Components/Form/Input.vue";
import DangerFeedback from "../../Components/Feedback/DangerFeedback.vue";
import Password from "../../Components/Form/Password.vue";
import Feedback from "../../Components/Feedback/Feedback.vue";
import PrimaryButton from "../../Components/Buttons/PrimaryButton.vue";

const props = defineProps({
    user: Object,
    password_min: Number,
    flash: Object,
});

const form = useForm({
    first_name: props.user?.first_name,
    last_name: props.user?.last_name,
    email: props.user?.email,
    password: null,
});
</script>
