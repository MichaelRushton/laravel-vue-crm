<template>
    <Head>
        <title>Sign in - {{ $page.props.app_name }}</title>
    </Head>
    <CenterScreen>
        <Form class="p-4 sm:w-96" @submit.prevent="form.post('/sign-in')">
            <Header>Sign in</Header>
            <SuccessNotice v-if="flash?.success">
                {{ flash.success }}
            </SuccessNotice>
            <InputGroup>
                <label for="email">Email</label>
                <Input type="email" id="email" v-model="form.email" required />
                <DangerFeedback v-if="form.errors.email">
                    {{ form.errors.email }}
                </DangerFeedback>
            </InputGroup>
            <InputGroup>
                <div class="flex items-baseline">
                    <Label for="password">Password</Label>
                    <Link href="/reset-password" class="ml-auto text-xs"
                        >Reset password</Link
                    >
                </div>
                <Input
                    type="password"
                    id="password"
                    v-model="form.password"
                    required
                />
                <DangerFeedback v-if="form.errors.password">
                    {{ form.errors.password }}
                </DangerFeedback>
            </InputGroup>
            <PrimaryButton type="submit" :disabled="form.processing">
                Sign in
            </PrimaryButton>
        </Form>
    </CenterScreen>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import CenterScreen from "../../Components/CenterScreen.vue";
import Form from "../../Components/Form/Form.vue";
import Header from "../../Components/Form/Header.vue";
import SuccessNotice from "../../Components/Notice/SuccessNotice.vue";
import InputGroup from "../../Components/Form/Inputs/InputGroup.vue";
import Input from "../../Components/Form/Inputs/Input.vue";
import DangerFeedback from "../../Components/Form/Feedback/DangerFeedback.vue";
import PrimaryButton from "../../Components/Form/Buttons/PrimaryButton.vue";

const props = defineProps({
    flash: Object,
});

const form = useForm({
    email: null,
    password: null,
});

defineOptions({ layout: false });
</script>
