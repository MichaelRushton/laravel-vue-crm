<template>
    <Head>
        <title>Reset password - {{ $page.props.app_name }}</title>
    </Head>
    <CenterScreen>
        <Form
            class="p-4 sm:w-96"
            @submit.prevent="form.patch('/reset-password')"
        >
            <SuccessNotice v-if="flash?.success">
                {{ flash.success }}
            </SuccessNotice>
            <template v-else>
                <Header>Reset password</Header>
                <input type="hidden" v-model="form.token" />
                <input type="hidden" v-model="form.email" />
                <DangerFeedback v-if="form.errors.email">
                    {{ form.errors.email }}
                </DangerFeedback>
                <InputGroup>
                    <label for="password">Password</label>
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
                <InputGroup>
                    <label for="password_confirmation">Confirm password</label>
                    <Input
                        type="password"
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        required
                    />
                    <DangerFeedback v-if="form.errors.password_confirmation">
                        {{ form.errors.password_confirmation }}
                    </DangerFeedback>
                </InputGroup>
                <PrimaryButton type="submit" :disabled="form.processing">
                    Reset
                </PrimaryButton>
            </template>
        </Form>
    </CenterScreen>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import CenterScreen from "../../Components/CenterScreen.vue";
import Form from "../../Components/Form/Form.vue";
import SuccessNotice from "../../Components/Notice/SuccessNotice.vue";
import Header from "../../Components/Form/Header.vue";
import InputGroup from "../../Components/Form/Inputs/InputGroup.vue";
import Input from "../../Components/Form/Inputs/Input.vue";
import DangerFeedback from "../../Components/Form/Feedback/DangerFeedback.vue";
import PrimaryButton from "../../Components/Form/Buttons/PrimaryButton.vue";

const props = defineProps({
    token: String,
    email: String,
    flash: Object,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: null,
    password_confirmation: null,
});

defineOptions({ layout: false });
</script>
