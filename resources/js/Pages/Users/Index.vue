<template>
    <Head>
        <title>Users - {{ $page.props.app_name }}</title>
    </Head>
    <div class="flex flex-col gap-4">
        <div class="flex items-center gap-4">
            <h1 class="text-xl">Users</h1>
            <SuccessLinkButton href="/users/create" class="ml-auto sm:ml-0">
                <PlusIcon class="size-6" />
            </SuccessLinkButton>
        </div>
        <SuccessNotice v-if="flash?.success" class="sm:w-fit">
            {{ flash.success }}
        </SuccessNotice>
        <div class="flex flex-col gap-4 sm:flex-row">
            <Search :search v-model="form.name" />
            <div class="flex gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <Select
                        @change="search"
                        v-model="form.role"
                        :options="roles"
                    >
                        <option value="">Role...</option>
                    </Select>
                    <Select
                        @change="search"
                        v-model="form.status"
                        :options="statuses"
                    >
                        <option value="">Status...</option>
                    </Select>
                </div>
                <NeutralButton
                    @click="reset"
                    class="flex items-center gap-2"
                    title="Reset"
                >
                    <BackspaceIcon class="size-6" />
                    <span class="hidden sm:inline">Reset</span>
                </NeutralButton>
            </div>
        </div>
        <div>
            <InfiniteScroll
                data="users"
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3"
            >
                <Card
                    v-for="user in users.data"
                    :key="user.uuid"
                    class="gap-4 p-4"
                >
                    <div class="flex items-start">
                        <Link :href="`/users/${user.uuid}/edit`">
                            {{ user.first_name }} {{ user.last_name }}
                        </Link>
                        <div
                            v-if="user.can_impersonate"
                            class="-mt-4 -mr-4 ml-auto cursor-pointer rounded-tr rounded-bl border-b border-l border-neutral-400 p-1.5 text-xs hover:bg-neutral-100"
                            :title="`Sign in as ${user.first_name} ${user.last_name}`"
                            @click="impersonate = user"
                        >
                            <ArrowRightEndOnRectangleIcon class="size-6" />
                        </div>
                    </div>
                    <div class="mt-auto flex text-xs">
                        <div>{{ user.role }}</div>
                        <div
                            class="ml-auto"
                            :class="{
                                'text-success-600': 'Active' === user.status,
                                'text-danger-600': 'Inactive' === user.status,
                            }"
                        >
                            {{ user.status }}
                        </div>
                    </div>
                </Card>
            </InfiniteScroll>
        </div>
    </div>
    <Modal
        v-if="impersonate"
        @close-modal="impersonate = null"
        class="gap-4 p-4"
    >
        <div>
            Sign in as {{ impersonate.first_name }} {{ impersonate.last_name }}?
        </div>
        <div class="grid grid-cols-2 gap-4 sm:flex">
            <NeutralLinkButton @click="impersonate = null" class="sm:ml-auto">
                No
            </NeutralLinkButton>
            <PrimaryLinkButton
                :href="`/users/${impersonate.uuid}/impersonate`"
                method="post"
            >
                Yes
            </PrimaryLinkButton>
        </div>
    </Modal>
</template>

<script setup>
import { ref } from "vue";
import { Head, InfiniteScroll, useForm } from "@inertiajs/vue3";
import SuccessLinkButton from "../../Components/Buttons/SuccessLinkButton.vue";
import {
    ArrowRightEndOnRectangleIcon,
    BackspaceIcon,
    PlusIcon,
} from "@heroicons/vue/24/outline";
import SuccessNotice from "../../Components/Notices/SuccessNotice.vue";
import Search from "../../Components/Form/Search.vue";
import Select from "../../Components/Form/Select.vue";
import NeutralButton from "../../Components/Buttons/NeutralButton.vue";
import Card from "../../Components/Card/Card.vue";
import Link from "../../Components/Text/Link.vue";
import Modal from "../../Components/Modal/Modal.vue";
import NeutralLinkButton from "../../Components/Buttons/NeutralLinkButton.vue";
import PrimaryLinkButton from "../../Components/Buttons/PrimaryLinkButton.vue";

const props = defineProps({
    users: Object,
    search: Object,
    roles: Array,
    statuses: Array,
    flash: Object,
});

const form = useForm({
    name: props.search.name,
    role: props.search.role,
    status: props.search.status,
});

const search = () => {
    form.get("/users", {
        preserveState: true,
        replace: true,
    });
};

const reset = () => {
    form.name = form.role = form.status = "";
    search();
};

const impersonate = ref(null);
</script>
