<script setup lang="ts">
import PwaStatus from '@/components/PwaStatus.vue';
import { Skeleton } from '@/components/ui/skeleton';
import AppLayout from '@/layouts/AppLayout.vue';
import { getContrastColor } from '@/lib/utils';
import { dashboard } from '@/routes';
import { type BreadcrumbItem, Transaction } from '@/types';
import { Deferred, Head } from '@inertiajs/vue3';
import { ArrowDownLeft, ArrowDownRight, ArrowUpRight, Receipt, TrendingDown, TrendingUp } from 'lucide-vue-next';

defineProps<{
    income?: string | number;
    expense?: string | number;
    transactions?: Transaction[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'داشبورد',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="داشبورد" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <div
                    class="group relative overflow-hidden rounded-xl border border-emerald-200 bg-gradient-to-br from-emerald-50 to-green-50 p-6 shadow-sm transition-all hover:shadow-md dark:border-emerald-800/50 dark:from-emerald-950/30 dark:to-green-950/20"
                >
                    <div class="absolute -top-4 -right-4 h-24 w-24 rounded-full bg-emerald-200/30 blur-2xl dark:bg-emerald-700/20"></div>
                    <div class="absolute -bottom-4 -left-4 h-20 w-20 rounded-full bg-green-200/30 blur-xl dark:bg-green-700/20"></div>

                    <Deferred data="income">
                        <template #fallback>
                            <div class="relative flex items-center gap-4">
                                <div class="rounded-lg bg-emerald-200/50 p-3 dark:bg-emerald-800/30">
                                    <Skeleton class="h-6 w-6" />
                                </div>
                                <div class="flex-1 space-y-2">
                                    <Skeleton class="h-3 w-24" />
                                    <Skeleton class="h-7 w-32" />
                                </div>
                            </div>
                        </template>

                        <div class="relative flex items-center gap-4">
                            <div class="rounded-lg bg-emerald-500/20 p-3 transition-transform group-hover:scale-110 dark:bg-emerald-600/30">
                                <TrendingUp class="h-6 w-6 text-emerald-700 dark:text-emerald-400" />
                            </div>
                            <div class="flex-1 space-y-1">
                                <span class="text-xs font-medium text-emerald-700/80 dark:text-emerald-400/80">جمع کل درآمد</span>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-2xl font-bold text-emerald-800 dark:text-emerald-300">{{ income }}</span>
                                    <span class="text-xs font-medium text-emerald-600 dark:text-emerald-500">تومان</span>
                                </div>
                            </div>
                            <ArrowUpRight
                                class="h-5 w-5 text-emerald-500 opacity-0 transition-opacity group-hover:opacity-100 dark:text-emerald-400"
                            />
                        </div>
                    </Deferred>
                </div>
                <div
                    class="group relative overflow-hidden rounded-xl transition-all hover:shadow-md"
                    :class="
                        expense
                            ? 'border border-rose-200 bg-gradient-to-br from-rose-50 to-red-50 p-6 shadow-sm dark:border-rose-800/50 dark:from-rose-950/30 dark:to-red-950/20'
                            : 'border border-sidebar-border/70 bg-gradient-to-br from-gray-50 to-slate-50 p-6 dark:border-sidebar-border dark:from-gray-950/20 dark:to-slate-950/10'
                    "
                >
                    <div v-if="expense" class="absolute -top-4 -right-4 h-24 w-24 rounded-full bg-rose-200/30 blur-2xl dark:bg-rose-700/20"></div>
                    <div v-if="expense" class="absolute -bottom-4 -left-4 h-20 w-20 rounded-full bg-red-200/30 blur-xl dark:bg-red-700/20"></div>

                    <Deferred data="expense">
                        <template #fallback>
                            <div class="relative flex items-center gap-4">
                                <div class="rounded-lg bg-rose-200/50 p-3 dark:bg-rose-800/30">
                                    <Skeleton class="h-6 w-6" />
                                </div>
                                <div class="flex-1 space-y-2">
                                    <Skeleton class="h-3 w-24" />
                                    <Skeleton class="h-7 w-32" />
                                </div>
                            </div>
                        </template>

                        <div class="relative flex items-center gap-4">
                            <div
                                class="rounded-lg p-3 transition-transform group-hover:scale-110"
                                :class="expense ? 'bg-rose-500/20 dark:bg-rose-600/30' : 'bg-gray-200/50 dark:bg-gray-700/30'"
                            >
                                <TrendingDown
                                    class="h-6 w-6"
                                    :class="expense ? 'text-rose-700 dark:text-rose-400' : 'text-gray-500 dark:text-gray-400'"
                                />
                            </div>
                            <div class="flex-1 space-y-1">
                                <span
                                    class="text-xs font-medium"
                                    :class="expense ? 'text-rose-700/80 dark:text-rose-400/80' : 'text-gray-600 dark:text-gray-400'"
                                >
                                    جمع کل هزینه
                                </span>
                                <div class="flex items-baseline gap-1">
                                    <span
                                        class="text-2xl font-bold"
                                        :class="expense ? 'text-rose-800 dark:text-rose-300' : 'text-gray-700 dark:text-gray-300'"
                                    >
                                        {{ expense }}
                                    </span>
                                    <span
                                        class="text-xs font-medium"
                                        :class="expense ? 'text-rose-600 dark:text-rose-500' : 'text-gray-500 dark:text-gray-400'"
                                    >
                                        تومان
                                    </span>
                                </div>
                            </div>
                            <ArrowDownRight
                                v-if="expense"
                                class="h-5 w-5 text-rose-500 opacity-0 transition-opacity group-hover:opacity-100 dark:text-rose-400"
                            />
                        </div>
                    </Deferred>
                </div>
            </div>
            <div class="rounded-xl border bg-card shadow-sm">
                <div class="border-b bg-muted/50 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <Receipt class="h-5 w-5 text-muted-foreground" />
                            <h3 class="text-lg font-semibold">آخرین تراکنش‌ها</h3>
                        </div>
                        <span class="text-sm text-muted-foreground">20 تراکنش اخیر</span>
                    </div>
                </div>

                <Deferred data="transactions">
                    <template #fallback>
                        <div class="divide-y">
                            <div v-for="i in 5" :key="i" class="p-4">
                                <div class="flex items-center gap-4">
                                    <Skeleton class="h-10 w-10 rounded-lg" />
                                    <div class="flex-1 space-y-2">
                                        <Skeleton class="h-4 w-32" />
                                        <Skeleton class="h-3 w-24" />
                                    </div>
                                    <Skeleton class="h-5 w-20" />
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="divide-y">
                        <div
                            v-for="transaction in transactions"
                            :key="transaction.id"
                            class="group flex items-start gap-4 p-4 transition-colors hover:bg-muted/50"
                        >
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg"
                                :class="transaction.type === 'INCOME' ? 'bg-emerald-100 dark:bg-emerald-950/50' : 'bg-rose-100 dark:bg-rose-950/50'"
                            >
                                <component
                                    :is="transaction.type === 'INCOME' ? ArrowDownLeft : ArrowUpRight"
                                    class="h-5 w-5"
                                    :class="
                                        transaction.type === 'INCOME' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'
                                    "
                                />
                            </div>

                            <div class="flex-1 space-y-2">
                                <div class="space-y-1">
                                    <p class="text-sm leading-none font-medium">{{ transaction.title }}</p>
                                    <div v-if="false" class="flex items-center gap-2">
                                        <span class="text-xs text-muted-foreground">
                                            <template v-if="transaction.type == 'INCOME'"></template>
                                            {{ transaction.user.name }}
                                        </span>
                                    </div>
                                </div>

                                <div v-if="transaction.tags.length > 0" class="flex flex-wrap gap-1.5">
                                    <span
                                        v-for="tag in transaction.tags"
                                        :key="tag.id"
                                        class="inline-flex items-center rounded-md px-3 py-1 text-xs font-medium"
                                        :style="{
                                            backgroundColor: tag.color,
                                            color: getContrastColor(tag.color),
                                            borderColor: tag.color + '40',
                                            borderWidth: '1px',
                                        }"
                                    >
                                        {{ tag.name }}
                                    </span>
                                </div>
                            </div>

                            <div class="shrink-0 space-y-1 text-left">
                                <div
                                    class="text-sm font-semibold"
                                    :class="
                                        transaction.type === 'INCOME' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'
                                    "
                                >
                                    {{ transaction.amount }} <span class="text-xs">تومان</span>
                                </div>
                                <p class="text-xs text-muted-foreground">{{ transaction.date }}</p>
                            </div>
                        </div>
                    </div>
                </Deferred>
            </div>
        </div>
    </AppLayout>
</template>
