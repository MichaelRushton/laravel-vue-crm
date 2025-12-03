<template>
    <Head>
        <title>Sign in - {{ $page.props.app_name }}</title>
    </Head>
    <SuccessNotice v-if="flash?.success">
        {{ flash.success }}
    </SuccessNotice>
    <DangerNotice v-else-if="flash?.error">
        {{ flash.error }}
    </DangerNotice>
    <form @submit.prevent="form.post('/sign-in')">
        <Card class="w-full gap-4 p-4 sm:w-96">
            <h1 class="text-center text-xl">Sign in</h1>
            <div class="flex flex-col gap-1">
                <label for="email">Email address</label>
                <Input type="email" id="email" v-model="form.email" required />
                <DangerFeedback v-if="form.errors.email">{{
                    form.errors.email
                }}</DangerFeedback>
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex items-baseline">
                    <label for="password">Password</label>
                    <Link
                        href="/reset-password"
                        class="text-primary-600 ml-auto text-xs"
                        >Forgot?</Link
                    >
                </div>
                <Password id="password" v-model="form.password" required />
                <DangerFeedback v-if="form.errors.password">{{
                    form.errors.password
                }}</DangerFeedback>
            </div>
            <PrimaryButton type="submit" :disabled="form.processing">
                Sign in
            </PrimaryButton>
        </Card>
    </form>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import CenterScreen from "../../Layouts/CenterScreen.vue";
import SuccessNotice from "../../Components/Notices/SuccessNotice.vue";
import DangerNotice from "../../Components/Notices/DangerNotice.vue";
import Card from "../../Components/Card/Card.vue";
import Input from "../../Components/Form/Input.vue";
import DangerFeedback from "../../Components/Feedback/DangerFeedback.vue";
import Link from "../../Components/Text/Link.vue";
import Password from "../../Components/Form/Password.vue";
import PrimaryButton from "../../Components/Buttons/PrimaryButton.vue";

defineProps({
    flash: Object,
});

const form = useForm({
    email: null,
    password: null,
});

defineOptions({ layout: CenterScreen });
</script>
