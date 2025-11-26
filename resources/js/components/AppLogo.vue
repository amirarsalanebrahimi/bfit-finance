<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 50" :class="cn('size-5 fill-blue', className)" v-bind="$attrs">
        <path
            fill="inherit"
            fill-rule="evenodd"
            d="M23.3,23.7c2.3,1.4,3.4,3.2,3.4,5.8v1.5c0,1.8-.7,3.4-2.1,4.8s-2.9,2.1-4.8,2.1H2.5V12.2h15.9c1.8,0,3.4.7,4.8,2.1,1.4,1.4,2.1,2.9,2.1,4.8s-.6,3.4-1.8,4.7h-.1ZM5.6,22.8h12.9c1,0,1.9-.3,2.7-1.1.8-.8,1.1-1.6,1.1-2.7s-.3-1.9-1.1-2.7-1.6-1.1-2.7-1.1H5.6v7.5h0v.2ZM23.6,29.6c0-1-.3-1.9-1.1-2.7-.8-.8-1.7-1.1-2.7-1.1H5.4v9h14.4c1,0,1.9-.3,2.7-1.1.8-.8,1.1-1.6,1.1-2.7v-1.5h0v.2Z"
        />
        <path
            fill="inherit"
            fill-rule="evenodd"
            d="M29.9,12.2h24.2v3.1h-24.2v-3.1ZM29.9,30.2c0-2.1.8-3.9,2.2-5.4s3.2-2.2,5.4-2.2h16.5v3.1h-16.5c-1.3,0-2.4.5-3.2,1.4-.9.9-1.4,1.9-1.4,3.2v7.5h-3.1v-7.5h.1Z"
        />
        <path fill="inherit" fill-rule="evenodd" d="M57.2,12.2h3.1v25.7h-3.1V12.2Z" />
        <path fill="inherit" fill-rule="evenodd" d="M87.5,12.1v3.1h-10.6v22.7h-3.1V15.2h-10.6v-3.1h24.3Z" />
    </svg>
</template>
