<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import AppContent from '@/components/AppContent.vue';
import AppHeader from '@/components/AppHeader.vue';
import AppShell from '@/components/AppShell.vue';
import AppNavigation from '@/components/AppNavigation.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const navigationRef = ref<InstanceType<typeof AppNavigation> | null>(null);
const navigationHeight = ref(0);

const updateNavigationHeight = () => {
    if (navigationRef.value?.$el) {
        navigationHeight.value = navigationRef.value.$el.offsetHeight;
    }
};

onMounted(() => {
    // Initial calculation
    updateNavigationHeight();

    // Recalculate on window resize
    window.addEventListener('resize', updateNavigationHeight);

    // Use ResizeObserver for more accurate tracking
    if (navigationRef.value?.$el) {
        const resizeObserver = new ResizeObserver(updateNavigationHeight);
        resizeObserver.observe(navigationRef.value.$el);

        onUnmounted(() => {
            resizeObserver.disconnect();
            window.removeEventListener('resize', updateNavigationHeight);
        });
    }
});
</script>

<template>
    <AppShell class="flex-col">
        <AppHeader :breadcrumbs="breadcrumbs" />
        <AppContent :style="{ paddingBottom: `${navigationHeight}px` }">
            <slot />
        </AppContent>
        <AppNavigation ref="navigationRef" />
    </AppShell>
</template>
