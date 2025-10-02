<template>
    <li>
        <Link
            v-if="undefined !== item.href"
            :href="`/${item.href}`"
            class="block p-4 hover:bg-neutral-100"
            :class="{ 'pl-8': submenu }"
            @click="open_menu = false"
        >
            {{ item.label }}
        </Link>
        <template v-else>
            <div
                class="flex cursor-pointer items-baseline p-4 hover:bg-neutral-100"
                @click="open_submenu = !open_submenu"
            >
                {{ item.label }}
                <span class="ml-auto text-xs">
                    <span v-if="open_submenu"></span>
                    <span v-else></span>
                </span>
            </div>
            <ul v-if="open_submenu">
                <MenuItem
                    v-for="(i, k) in item.items"
                    :key="k"
                    :item="i"
                    :submenu="true"
                />
            </ul>
        </template>
    </li>
</template>

<script setup>
import { ref } from "vue";
import Link from "../../Components/Link.vue";

defineProps({
    item: Object,
    submenu: Boolean,
});

const open_menu = defineModel();
const open_submenu = ref(false);
</script>
