<template>
    <Link
        v-if="undefined !== item.href"
        :href="`/${item.href}`"
        class="p-4 hover:bg-neutral-100"
        :class="{ 'border-l-4 border-neutral-400 pl-3': is_submenu }"
        @click="open_menu = false"
    >
        {{ item.label }}
    </Link>
    <template v-else>
        <div
            class="flex cursor-pointer items-center p-4 hover:bg-neutral-100"
            :class="{ 'border-l-4 border-neutral-400 pl-3': open_submenu }"
            @click="open_submenu = !open_submenu"
        >
            {{ item.label }}
            <span class="ml-auto">
                <ChevronDownIcon v-if="open_submenu" class="size-4" />
                <ChevronRightIcon v-else class="size-4" />
            </span>
        </div>
        <MenuItem
            v-if="open_submenu"
            v-for="(i, k) in item.items"
            :key="k"
            :item="i"
            :is_submenu="true"
            v-model="open_menu"
        />
    </template>
</template>

<script setup>
import { ref } from "vue";
import Link from "../Text/Link.vue";
import { ChevronDownIcon, ChevronRightIcon } from "@heroicons/vue/24/outline";

defineProps({
    item: Object,
    is_submenu: Boolean,
});

const open_menu = defineModel();
const open_submenu = ref(false);
</script>
