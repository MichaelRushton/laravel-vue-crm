<template>
    <Head>
        <title>Users - {{ $page.props.app_name }}</title>
    </Head>
    <Search :search url="/users" />
    <SuccessNotice v-if="flash?.success" class="mx-4 mb-4 sm:w-fit">
        {{ flash.success }}
    </SuccessNotice>
    <div>
        <TableRowStriped v-for="user in users.data" :key="user.id">
            <div class="flex items-baseline sm:block sm:w-60">
                <Link :href="`/users/${user.id}/edit`">
                    {{ user.name }}
                </Link>
                <div
                    v-if="user.can_impersonate"
                    class="ml-auto cursor-pointer text-xs sm:mt-2 sm:ml-0"
                    @click="impersonate = user"
                >
                    Sign in
                </div>
            </div>
            <div class="mt-2 text-xs sm:mt-0 sm:text-base">{{ user.role }}</div>
        </TableRowStriped>
    </div>
    <BeforeFooter>
        <InfiniteScroll :data="users" :only="['users']" />
    </BeforeFooter>
    <Footer class="sm:justify-start">
        <PrimaryLinkButton href="/users/create">Add user</PrimaryLinkButton>
    </Footer>
    <Modal v-if="impersonate" @close-modal="impersonate = null">
        <template #header>Sign in</template>
        Are you sure you would like to sign in as
        <span class="font-semibold"
            >{{ impersonate.first_name }} {{ impersonate.last_name }}</span
        >?
        <template #buttons>
            <DefaultButton @click="impersonate = null">No</DefaultButton>
            <PrimaryLinkButton
                :href="`/users/${impersonate.id}/impersonate`"
                method="post"
                >Yes</PrimaryLinkButton
            >
        </template>
    </Modal>
</template>

<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import Search from "../../Components/Search/Search.vue";
import SuccessNotice from "../../Components/Notice/SuccessNotice.vue";
import TableRowStriped from "../../Components/Table/TableRowStriped.vue";
import Link from "../../Components/Link.vue";
import InfiniteScroll from "../../Components/Search/InfiniteScroll.vue";
import Modal from "../../Components/Modal/Modal.vue";
import DefaultButton from "../../Components/Form/Buttons/DefaultButton.vue";
import PrimaryLinkButton from "../../Components/Form/Buttons/PrimaryLinkButton.vue";
import Footer from "../../Layouts/Components/Footer.vue";
import BeforeFooter from "../../Layouts/Components/BeforeFooter.vue";

defineProps({
    search: String,
    users: Object,
    flash: Object,
});

const impersonate = ref(null);
</script>
