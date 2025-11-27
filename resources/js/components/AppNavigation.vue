<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { create } from '@/routes/transactions';
import DashboardController from '@/actions/App/Http/Controllers/DashboardController';
import { HouseIcon } from 'lucide-vue-next';
import type { NavItem } from '@/types';

// You can customize these navigation items as needed
const navItems: NavItem[] = [
    { title: 'Home', href: DashboardController.url(), icon: HouseIcon },
];
</script>

<template>
    <nav class="fixed right-0 bottom-0 left-0 z-50 px-4 py-8 lg:hidden">
        <div class="mx-auto flex justify-between gap-8 max-w-7xl px-4">
            <div class="flex items-center justify-around py-3 rounded-4xl border-2 border-ring/20 backdrop-blur-xs">
                <Link
                    v-for="item in navItems"
                    :key="item.title"
                    :href="item.href"
                    class="flex flex-col items-center justify-center rounded-lg px-3 py-2 transition-colors hover:bg-gray-100 active:bg-gray-200"
                    :class="[isCurrentRoute(item.href) ? 'text-blue-600' : 'text-gray-600']"
                >
                    <component v-if="item.icon" :is="item.icon" class="h-5 w-5" />
                    <span class="text-xs font-medium">{{ item.title }}</span>
                </Link>
            </div>
            <div>
                <Link :href="create.url()">
                    <span></span>
                </Link>
            </div>
        </div>
    </nav>
</template>
