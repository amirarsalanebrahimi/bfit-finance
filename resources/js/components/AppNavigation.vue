<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { create } from '@/routes/transactions';
import DashboardController from '@/actions/App/Http/Controllers/DashboardController';

// You can customize these navigation items as needed
const navItems = [
    { name: 'Home', href: DashboardController.url(), icon:  },
    { name: 'Dashboard', href: '/dashboard', icon: '📊' },
    { name: 'Profile', href: '/profile', icon: '👤' },
    { name: 'Settings', href: '/settings', icon: '⚙️' },
];
</script>

<template>
    <nav class="fixed right-0 bottom-0 left-0 z-50 px-4 py-8 lg:hidden">
        <div class="mx-auto flex justify-between gap-8 max-w-7xl px-4">
            <div class="flex items-center justify-around py-3 rounded-4xl border-2 border-ring/20 backdrop-blur-xs">
                <Link
                    v-for="item in navItems"
                    :key="item.name"
                    :href="item.href"
                    class="flex flex-col items-center justify-center rounded-lg px-3 py-2 transition-colors hover:bg-gray-100 active:bg-gray-200"
                    :class="[$page.url === item.href ? 'text-blue-600' : 'text-gray-600']"
                >
                    <span class="mb-1 text-2xl">{{ item.icon }}</span>
                    <span class="text-xs font-medium">{{ item.name }}</span>
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
