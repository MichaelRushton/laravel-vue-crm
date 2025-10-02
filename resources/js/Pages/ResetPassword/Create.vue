<template>
    <Head>
        <title>Reset password - {{ $page.props.app_name }}</title>
    </Head>
    <CenterScreen>
        <Form
            class="p-4 sm:w-96"
            @submit.prevent="form.post('/reset-password')"
        >
            <Header>Reset password</Header>
            <InputGroup>
                <label for="email">Email</label>
                <Input type="email" id="email" v-model="form.email" required />
                <DangerFeedback v-if="form.errors.email">
                    {{ form.errors.email }}
                </DangerFeedback>
            </InputGroup>
            <PrimaryButton type="submit" :disabled="form.processing">
                Reset
            </PrimaryButton>
        </Form>
    </CenterScreen>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import CenterScreen from "../../Components/CenterScreen.vue";
import Form from "../../Components/Form/Form.vue";
import Header from "../../Components/Form/Header.vue";
import InputGroup from "../../Components/Form/Inputs/InputGroup.vue";
import Input from "../../Components/Form/Inputs/Input.vue";
import DangerFeedback from "../../Components/Form/Feedback/DangerFeedback.vue";
import PrimaryButton from "../../Components/Buttons/PrimaryButton.vue";

const form = useForm({
    email: null,
});

defineOptions({ layout: false });
</script>
