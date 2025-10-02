<template>
    <Head>
        <title>Dashboard - {{ $page.props.app_name }}</title>
    </Head>
    <div class="grid gap-4 p-4 sm:grid-cols-2">
        <Card>
            <CardHeader>
                Recent Notifications
                <Link href="/users/notifications" class="ml-auto text-xs"
                    >See all</Link
                >
            </CardHeader>
            <div class="h-96 overflow-scroll">
                <TableRowStriped
                    v-for="notification in notifications"
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
        </Card>
    </div>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Card from "../../Components/Card/Card.vue";
import CardHeader from "../../Components/Card/CardHeader.vue";
import TableRowStriped from "../../Components/Table/TableRowStriped.vue";
import Link from "../../Components/Link.vue";

defineProps({
    notifications: Array,
});
</script>
