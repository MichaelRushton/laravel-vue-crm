<template>
    <Head>
        <title>Reset password - {{ $page.props.app_name }}</title>
    </Head>
    <form @submit.prevent="form.patch(`/reset-password/${uuid}`)">
        <input type="hidden" v-model="form.token" />
        <Card class="w-full gap-4 p-4 sm:w-96">
            <h1 class="text-center text-xl">Reset password</h1>
            <div class="flex flex-col gap-1">
                <label for="password">Password</label>
                <Password id="password" v-model="form.password" />
                <DangerFeedback v-if="form.errors.password">{{
                    form.errors.password
                }}</DangerFeedback>
                <Feedback v-else>
                    Your password must be at least
                    {{ password_min }} characters.
                </Feedback>
            </div>
            <PrimaryButton type="submit" :disabled="form.processing">
                Reset
            </PrimaryButton>
        </Card>
    </form>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import CenterScreen from "../../Layouts/CenterScreen.vue";
import Card from "../../Components/Card/Card.vue";
import Password from "../../Components/Form/Password.vue";
import DangerFeedback from "../../Components/Feedback/DangerFeedback.vue";
import Feedback from "../../Components/Feedback/Feedback.vue";
import PrimaryButton from "../../Components/Buttons/PrimaryButton.vue";

const props = defineProps({
    uuid: String,
    token: String,
    password_min: Number,
});

const form = useForm({
    token: props.token,
    password: null,
});

defineOptions({ layout: CenterScreen });
</script>
