<template>
    <nav class="fixed top-0 flex w-full border-b border-neutral-400 bg-white">
        <div
            class="cursor-pointer p-4 hover:bg-neutral-100"
            @click="open = true"
        >
            <Bars3Icon class="size-6" />
        </div>
        <DropdownContainer
            class="ml-auto"
            :title="`${auth.first_name} ${auth.last_name}`"
        >
            <template #toggle>
                <div class="flex cursor-pointer gap-2 p-4 hover:bg-neutral-100">
                    <UserCircleIcon class="size-6" />
                    <div class="hidden sm:block">
                        {{ auth.first_name }} {{ auth.last_name }}
                    </div>
                </div>
            </template>
            <Dropdown class="-top-1 right-2 w-36">
                <Link
                    href="/user/edit"
                    class="rounded-t p-3 hover:bg-neutral-100"
                >
                    Update details
                </Link>
                <Link
                    href="/sign-out"
                    class="rounded-b p-3 text-left hover:bg-neutral-100"
                    method="delete"
                >
                    Sign out
                </Link>
            </Dropdown>
        </DropdownContainer>
    </nav>
    <aside
        class="fixed top-0 z-10 flex h-screen w-60 flex-col overflow-y-auto border-r border-neutral-400 bg-white duration-300"
        :class="open ? 'left-0' : '-left-60 sm:left-0'"
    >
        <div
            class="cursor-pointer p-4 hover:bg-neutral-100 sm:hidden"
            @click="open = false"
        >
            <XMarkIcon class="m-auto size-6" />
        </div>
        <MenuItem v-for="(item, key) in menu" :key :item v-model="open" />
    </aside>
    <main class="mt-14 p-4 sm:ml-60">
        <div
            v-if="is_impersonated"
            class="mb-4 text-center text-xs sm:text-right"
        >
            You are impersonating {{ auth.first_name }} {{ auth.last_name }}.
            <Link
                href="/users/impersonate"
                class="text-primary-600"
                method="delete"
            >
                Switch back </Link
            >.
        </div>
        <slot />
    </main>
</template>

<script setup>
import { ref } from "vue";
import {
    Bars3Icon,
    UserCircleIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";
import DropdownContainer from "../Components/Dropdown/DropdownContainer.vue";
import Dropdown from "../Components/Dropdown/Dropdown.vue";
import Link from "../Components/Text/Link.vue";
import MenuItem from "../Components/Menu/MenuItem.vue";

defineProps({
    auth: Object,
    menu: Array,
    is_impersonated: Boolean,
});

const open = ref(false);
</script>
