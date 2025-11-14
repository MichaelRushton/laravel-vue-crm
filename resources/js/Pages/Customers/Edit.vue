<template>
    <Head>
        <title>
            {{ customer ? "Edit" : "Create" }} customer -
            {{ $page.props.app_name }}
        </title>
    </Head>
    <h1 class="text-xl">{{ customer ? "Edit" : "Create" }} customer</h1>
    <form
        @submit.prevent="
            customer
                ? form.patch(`/customers/${customer.uuid}`)
                : form.post('/customers')
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
            <div class="grid grid-cols-3 gap-4">
                <NeutralLinkButton href="/customers">Back</NeutralLinkButton>
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
import NeutralLinkButton from "../../Components/Buttons/NeutralLinkButton.vue";
import PrimaryButton from "../../Components/Buttons/PrimaryButton.vue";

const props = defineProps({
    customer: Object,
});

const form = useForm({
    first_name: props.customer?.first_name,
    last_name: props.customer?.last_name,
    email: props.customer?.email,
});
</script>
