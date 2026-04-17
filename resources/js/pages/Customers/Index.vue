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
            <Search :search v-model="form.name" />
            <ResetButton @click="reset" />
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
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <div>
                            {{ customer.first_name }} {{ customer.last_name }}
                        </div>
                        <div class="flex items-center gap-4 md:ml-auto">
                            <div
                                @click="show(customer.uuid)"
                                class="cursor-pointer"
                                title="View"
                            >
                                <EyeIcon class="size-3" />
                            </div>
                            <Link
                                :href="`/customers/${customer.uuid}/edit`"
                                title="Edit"
                            >
                                <PencilIcon class="size-3" />
                            </Link>
                        </div>
                    </div>
                </Card>
            </InfiniteScroll>
        </div>
    </div>
    <Show v-model="customer" />
</template>

<script setup>
import { ref } from "vue";
import { Head, InfiniteScroll, useForm, useHttp } from "@inertiajs/vue3";
import SuccessLinkButton from "@/components/Buttons/SuccessLinkButton.vue";
import { EyeIcon, PencilIcon, PlusIcon } from "@heroicons/vue/24/outline";
import SuccessNotice from "@/components/Notices/SuccessNotice.vue";
import Search from "@/components/Form/Search.vue";
import Card from "@/components/Card/Card.vue";
import Link from "@/components/Text/Link.vue";
import ResetButton from "@/components/Buttons/ResetButton.vue";
import Show from "./Show.vue";

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
        only: ["customers", "search"],
        reset: ["customers"],
        preserveState: true,
        replace: true,
    });
};

const reset = () => {
    form.name = "";
    search();
};

const customer = ref(null);

const http = useHttp();

const show = (customer_id) => {
    http.get(`/customers/${customer_id}`, {
        onSuccess: (response) => {
            customer.value = response.customer;
        },
    });
};
</script>
