<template>
    <Head>
        <title>Sign ins - {{ $page.props.app_name }}</title>
    </Head>
    <Search :search url="/sign-ins" />
    <div>
        <TableRowStriped v-for="sign_in in sign_ins.data" :key="sign_in.id">
            <div class="sm:w-1/5">{{ sign_in.created_at }}</div>
            <div class="sm:w-1/5">{{ sign_in.ip_address }}</div>
            <div class="sm:w-1/5">{{ sign_in.email }}</div>
            <div class="sm:w-1/5">{{ sign_in.user }}</div>
            <div class="sm:w-1/5">
                <span v-if="sign_in.correct_password" class="text-green-500"
                    >Success</span
                >
                <span
                    v-else-if="false === sign_in.correct_password"
                    class="text-red-500"
                    >Failure</span
                >
            </div>
        </TableRowStriped>
    </div>
    <InfiniteScroll :data="sign_ins" :only="['sign_ins']" />
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Search from "../../Components/Search/Search.vue";
import TableRowStriped from "../../Components/Table/TableRowStriped.vue";
import InfiniteScroll from "../../Components/Search/InfiniteScroll.vue";

defineProps({
    search: String,
    sign_ins: Object,
});
</script>
