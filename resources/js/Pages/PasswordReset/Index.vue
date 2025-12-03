<template>
    <Head>
        <title>Reset password - {{ $page.props.app_name }}</title>
    </Head>
    <form @submit.prevent="form.post('/reset-password')">
        <Card class="w-full gap-4 p-4 sm:w-96">
            <h1 class="text-center text-xl">Reset password</h1>
            <div class="flex flex-col gap-1">
                <label for="email">Email address</label>
                <Input type="email" id="email" v-model="form.email" required />
                <DangerFeedback v-if="form.errors.email">{{
                    form.errors.email
                }}</DangerFeedback>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <NeutralLinkButton href="/sign-in">Back</NeutralLinkButton>
                <PrimaryButton
                    type="submit"
                    :disabled="form.processing"
                    class="col-span-2"
                >
                    Request
                </PrimaryButton>
            </div>
        </Card>
    </form>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import CenterScreen from "../../Layouts/CenterScreen.vue";
import Card from "../../Components/Card/Card.vue";
import Input from "../../Components/Form/Input.vue";
import DangerFeedback from "../../Components/Feedback/DangerFeedback.vue";
import NeutralLinkButton from "../../Components/Buttons/NeutralLinkButton.vue";
import PrimaryButton from "../../Components/Buttons/PrimaryButton.vue";

const form = useForm({
    email: null,
});

defineOptions({ layout: CenterScreen });
</script>
