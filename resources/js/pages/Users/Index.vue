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
            <div class="flex flex-row gap-4">
                <Search :search v-model="form.name" />
                <ResetButton @click="reset" class="sm:hidden" />
            </div>
            <div class="flex">
                <InputPrepend>Role</InputPrepend>
                <Select
                    class="grow rounded-l-none"
                    @change="search"
                    v-model="form.role"
                    :options="roles"
                >
                    <option value="">All</option>
                </Select>
            </div>
            <div class="flex">
                <InputPrepend>Status</InputPrepend>
                <Select
                    class="grow rounded-l-none"
                    @change="search"
                    v-model="form.status"
                    :options="statuses"
                >
                    <option value="">All</option>
                </Select>
            </div>
            <ResetButton @click="reset" class="hidden sm:flex" />
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
                        <div @click="show(user.uuid)" class="cursor-pointer">
                            {{ user.first_name }} {{ user.last_name }}
                        </div>
                        <div
                            v-if="user.can_impersonate"
                            class="border-neutral-default -mt-4 -mr-4 ml-auto cursor-pointer rounded-tr rounded-bl border-b border-l p-1.5 text-xs hover:bg-neutral-100"
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
    <Show v-model="user" />
    <Impersonate v-model="impersonate" />
</template>

<script setup>
import { ref } from "vue";
import { Head, InfiniteScroll, useForm, useHttp } from "@inertiajs/vue3";
import SuccessLinkButton from "@/components/Buttons/SuccessLinkButton.vue";
import {
    ArrowRightEndOnRectangleIcon,
    PlusIcon,
} from "@heroicons/vue/24/outline";
import SuccessNotice from "@/components/Notices/SuccessNotice.vue";
import Search from "@/components/Form/Search.vue";
import Select from "@/components/Form/Select.vue";
import Card from "@/components/Card/Card.vue";
import Link from "@/components/Text/Link.vue";
import InputPrepend from "@/components/Form/Input/InputPrepend.vue";
import ResetButton from "@/components/Buttons/ResetButton.vue";
import Impersonate from "./Impersonate.vue";
import Show from "./Show.vue";

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
        only: ["users", "search"],
        reset: ["users"],
        preserveState: true,
        replace: true,
    });
};

const reset = () => {
    form.name = form.role = "";
    form.status = "active";
    search();
};

const user = ref(null);

const http = useHttp();

const show = (user_id) => {
    http.get(`/users/${user_id}`, {
        onSuccess: (response) => {
            user.value = response;
        },
    });
};

const impersonate = ref(null);
</script>
