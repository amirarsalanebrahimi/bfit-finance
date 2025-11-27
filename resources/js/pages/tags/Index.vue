<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { create } from '@/routes/transactions';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'داشبورد',
        href: dashboard().url,
    },
    {
        title: 'تگ ها',
        href: create().url,
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="تگ ها" />

        <div class="flex flex-col space-y-6 px-4 py-6 md:mx-auto md:max-w-md">
            <Heading title="تگ ها" />

            <!-- Maintenance Notice -->
            <div class="rounded-lg border border-[--color-blue]/20 bg-[--color-blue]/5 p-8 text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[--color-blue]/10">
                    <svg class="h-6 w-6 text-[--color-blue]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>

                <h3 class="mb-2 text-base font-semibold text-foreground">
                    در حال بروزرسانی
                </h3>

                <p class="text-sm text-muted-foreground">
                    این بخش در حال توسعه است و به زودی در دسترس خواهد بود
                </p>

                <!-- Loading animation -->
                <div class="mt-6 flex justify-center gap-1.5">
                    <div class="h-1.5 w-1.5 animate-bounce rounded-full bg-[--color-blue]" style="animation-delay: 0ms"></div>
                    <div class="h-1.5 w-1.5 animate-bounce rounded-full bg-[--color-blue]" style="animation-delay: 150ms"></div>
                    <div class="h-1.5 w-1.5 animate-bounce rounded-full bg-[--color-blue]" style="animation-delay: 300ms"></div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
