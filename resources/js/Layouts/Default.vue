<template>
    <nav class="fixed top-0 flex w-full border-b border-neutral-400 bg-white">
        <div
            class="cursor-pointer p-4 hover:bg-neutral-100"
            @click="open = true"
        >
            Menu
        </div>
        <DropdownContainer class="ml-auto">
            <template #toggle>
                <button
                    class="cursor-pointer p-4 hover:bg-neutral-100"
                    type="button"
                >
                    {{ auth.first_name }} {{ auth.last_name }}
                </button>
            </template>
            <Dropdown class="top-1 right-1 w-48">
                <DropdownLink
                    v-if="is_impersonated"
                    href="/users/impersonate"
                    method="delete"
                    class="rounded-t"
                    >Unimpersonate</DropdownLink
                >
                <DropdownLink
                    href="/sign-out"
                    method="delete"
                    class="rounded-b"
                    :class="{ 'rounded-t': !is_impersonated }"
                    >Sign out</DropdownLink
                >
            </Dropdown>
        </DropdownContainer>
    </nav>
    <aside
        class="fixed top-0 z-10 h-screen w-60 border-r border-neutral-400 bg-white duration-300"
        :class="open ? 'left-0' : '-left-60 sm:left-0'"
    >
        <ul>
            <li
                class="cursor-pointer p-4 hover:bg-neutral-100 sm:hidden"
                @click="open = false"
            >
                Close
            </li>
            <MenuItem
                v-for="(item, key) in menu"
                :key="key"
                :item
                v-model="open"
            />
        </ul>
    </aside>
    <main class="mt-14 sm:ml-60">
        <slot />
    </main>
</template>

<script setup>
import { ref } from "vue";
import DropdownContainer from "../Components/Dropdown/DropdownContainer.vue";
import Dropdown from "../Components/Dropdown/Dropdown.vue";
import DropdownLink from "../Components/Dropdown/DropdownLink.vue";
import MenuItem from "./Components/MenuItem.vue";

defineProps({
    auth: Object,
    menu: Array,
    is_impersonated: Boolean,
});

const open = ref(false);
</script>
