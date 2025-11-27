<script setup lang="ts">
import { InertiaLinkProps, Link, usePage } from '@inertiajs/vue3';
import DashboardController from '@/actions/App/Http/Controllers/DashboardController';
import TransactionController from '@/actions/App/Http/Controllers/TransactionController';
import { FilePlusCorner, Gauge, ChartLineIcon, TagsIcon } from 'lucide-vue-next';
import type { NavItem } from '@/types';
import { computed } from 'vue';
import { toUrl, urlIsActive } from '@/lib/utils';
import TagController from '@/actions/App/Http/Controllers/TagController';

const page = usePage();

const isCurrentRoute = computed(() => (url: NonNullable<InertiaLinkProps['href']>) => urlIsActive(url, page.url));

const activeItemStyles = computed(
    () => (url: NonNullable<InertiaLinkProps['href']>) =>
        isCurrentRoute.value(toUrl(url)) ? 'bg-accent' : '',
);

// You can customize these navigation items as needed
const navItems: NavItem[] = [
    { title: 'داشبورد', href: DashboardController.url(), icon: Gauge },
    { title: 'تراکنش', href: TransactionController.index().url, icon: ChartLineIcon },
    { title: 'تگ', href: TagController.index().url, icon: TagsIcon }
];
</script>

<template>
    <nav class="fixed right-0 bottom-0 left-0 z-50 px-4 py-4 lg:hidden">
        <div class="mx-auto flex max-w-7xl justify-between gap-4">
            <div class="grow flex items-center justify-between rounded-full border border-ring/20 backdrop-blur-md py-1 px-1">
                <Link
                    v-for="item in navItems"
                    :key="item.title"
                    :href="item.href"
                    class="grow flex flex-col gap-1 items-center justify-center rounded-full px-3 py-2 transition-colors text-foreground"
                    :class="activeItemStyles(item.href)"
                >
                    <component v-if="item.icon" :is="item.icon" class="size-4" />
                    <span class="text-xs font-medium">{{ item.title }}</span>
                </Link>
            </div>
            <div v-if="!isCurrentRoute(TransactionController.create().url)" class="border border-blue bg-blue/10 ring-4 ring-blue/20 backdrop-blur-md rounded-full aspect-square size-14">
                <Link
                    class="flex items-center justify-center size-full text-blue"
                    :href="TransactionController.create().url"
                >
                    <FilePlusCorner class="size-5" />
                </Link>
            </div>
        </div>
    </nav>
</template>
