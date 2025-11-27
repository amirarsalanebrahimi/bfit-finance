<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

// You can customize these navigation items as needed
const navItems = [
    { name: 'Home', href: '/', icon: '🏠' },
    { name: 'Dashboard', href: '/dashboard', icon: '📊' },
    { name: 'Profile', href: '/profile', icon: '👤' },
    { name: 'Settings', href: '/settings', icon: '⚙️' },
];
</script>

<template>
    <nav class="fixed right-0 bottom-0 left-0 z-50 border-t border-gray-200 bg-white shadow-lg">
        <div class="mx-auto max-w-7xl px-4">
            <div class="flex items-center justify-around py-3">
                <Link
                    v-for="item in navItems"
                    :key="item.name"
                    :href="item.href"
                    class="flex min-w-[60px] flex-col items-center justify-center rounded-lg px-3 py-2 transition-colors hover:bg-gray-100 active:bg-gray-200"
                    :class="[$page.url === item.href ? 'text-blue-600' : 'text-gray-600']"
                >
                    <span class="mb-1 text-2xl">{{ item.icon }}</span>
                    <span class="text-xs font-medium">{{ item.name }}</span>
                </Link>
            </div>
        </div>
    </nav>
</template>
