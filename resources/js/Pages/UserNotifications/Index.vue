<template>
    <Head>
        <title>Notifications - {{ $page.props.app_name }}</title>
    </Head>
    <Search :search url="/users/notifications" />
    <div>
        <TableRowStriped
            v-for="notification in notifications.data"
            :key="notification.id"
        >
            <div>
                {{ notification.message }}
                <div class="mt-1 text-xs">
                    {{ notification.created_at }}
                </div>
            </div>
        </TableRowStriped>
    </div>
    <InfiniteScroll :data="notifications" :only="['notifications']" />
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Search from "../../Components/Search/Search.vue";
import TableRowStriped from "../../Components/Table/TableRowStriped.vue";
import InfiniteScroll from "../../Components/Search/InfiniteScroll.vue";

defineProps({
    search: String,
    notifications: Object,
});
</script>
