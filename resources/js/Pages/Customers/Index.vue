<template>
    <Head>
        <title>Customers - {{ $page.props.app_name }}</title>
    </Head>
    <div class="flex flex-col gap-4">
        <div class="flex items-center gap-4">
            <h1 class="text-xl">Customers</h1>
            <SuccessLinkButton href="/customers/create" class="ml-auto sm:ml-0">
                <PlusIcon class="size-6" />
            </SuccessLinkButton>
        </div>
        <SuccessNotice v-if="flash?.success" class="sm:w-fit">
            {{ flash.success }}
        </SuccessNotice>
        <div class="flex flex-row gap-4">
            <Search :search v-model="form.name" class="w-full sm:w-fit" />
            <NeutralButton
                @click="reset"
                class="flex items-center gap-2"
                title="Reset"
            >
                <BackspaceIcon class="size-6" />
                <span class="hidden sm:inline">Reset</span>
            </NeutralButton>
        </div>
        <div>
            <InfiniteScroll
                data="customers"
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3"
            >
                <Card
                    v-for="customer in customers.data"
                    :key="customer.uuid"
                    class="gap-4 p-4"
                >
                    <div>
                        <Link :href="`/customers/${customer.uuid}/edit`">
                            {{ customer.first_name }} {{ customer.last_name }}
                        </Link>
                    </div>
                </Card>
            </InfiniteScroll>
        </div>
    </div>
</template>

<script setup>
import { Head, InfiniteScroll, useForm } from "@inertiajs/vue3";
import SuccessLinkButton from "../../Components/Buttons/SuccessLinkButton.vue";
import { BackspaceIcon, PlusIcon } from "@heroicons/vue/24/outline";
import SuccessNotice from "../../Components/Notices/SuccessNotice.vue";
import Search from "../../Components/Form/Search.vue";
import NeutralButton from "../../Components/Buttons/NeutralButton.vue";
import Card from "../../Components/Card/Card.vue";
import Link from "../../Components/Text/Link.vue";

const props = defineProps({
    customers: Object,
    search: Object,
    flash: Object,
});

const form = useForm({
    name: props.search.name,
});

const search = () => {
    form.get("/customers", {
        preserveState: true,
        replace: true,
    });
};

const reset = () => {
    form.name = "";
    search();
};
</script>
