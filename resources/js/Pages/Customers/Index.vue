<template>
    <Head>
        <title>Customers - {{ $page.props.app_name }}</title>
    </Head>
    <Search :search url="/customers" />
    <SuccessNotice v-if="flash?.success" class="mx-4 mb-4 sm:w-fit">
        {{ flash.success }}
    </SuccessNotice>
    <WarningNotice v-if="flash?.warning" class="mx-4 mb-4 sm:w-fit">
        {{ flash.warning }}
        <template v-if="flash.undo">
            <Link :href="flash.undo" method="patch"><u>Undo</u></Link
            >.
        </template>
    </WarningNotice>
    <div>
        <TableRowStriped v-for="customer in customers.data" :key="customer.id">
            <div>
                <Link :href="`/customers/${customer.id}/edit`">
                    {{ customer.first_name }} {{ customer.last_name }}
                </Link>
            </div>
        </TableRowStriped>
    </div>
    <BeforeFooter>
        <InfiniteScroll :data="customers" :only="['customers']" />
    </BeforeFooter>
    <Footer class="sm:justify-start">
        <PrimaryLinkButton href="/customers/create"
            >Add customer</PrimaryLinkButton
        >
    </Footer>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Search from "../../Components/Search/Search.vue";
import SuccessNotice from "../../Components/Notice/SuccessNotice.vue";
import TableRowStriped from "../../Components/Table/TableRowStriped.vue";
import Link from "../../Components/Link.vue";
import InfiniteScroll from "../../Components/Search/InfiniteScroll.vue";
import PrimaryLinkButton from "../../Components/Form/Buttons/PrimaryLinkButton.vue";
import Footer from "../../Layouts/Components/Footer.vue";
import BeforeFooter from "../../Layouts/Components/BeforeFooter.vue";
import WarningNotice from "../../Components/Notice/WarningNotice.vue";

defineProps({
    search: String,
    customers: Object,
    flash: Object,
});
</script>
