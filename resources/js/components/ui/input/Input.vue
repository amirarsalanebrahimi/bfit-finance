<script setup lang="ts">
import { cn } from '@/lib/utils';
import { useVModel } from '@vueuse/core';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    defaultValue?: string | number;
    modelValue?: string | number;
    class?: HTMLAttributes['class'];
}>();

const emits = defineEmits<{
    (e: 'update:modelValue', payload: string | number): void;
}>();

const modelValue = useVModel(props, 'modelValue', emits, {
    passive: true,
    defaultValue: props.defaultValue,
});
</script>

<template>
    <input
        v-model="modelValue"
        data-slot="input"
        :class="
            cn(
                'peer/input',
                'flex',
                'w-full',
                'min-w-0',
                'rounded-md',
                'border',
                'border-input',
                'bg-transparent',
                'px-4.5',
                'py-4',
                'text-base',
                'shadow-xs',
                'appearance-none',
                'transition-[color,box-shadow]',
                'outline-none',
                'selection:bg-primary',
                'selection:text-primary-foreground',
                'file:inline-flex',
                'file:h-7',
                'file:border-0',
                'file:bg-transparent',
                'file:text-sm',
                'file:font-medium',
                'file:text-foreground',
                'placeholder-transparent',
                // 'disabled:pointer-events-none',
                'disabled:cursor-not-allowed',
                'disabled:opacity-50',
                'md:text-sm',
                'dark:bg-input/30',

                'focus-visible:border-blue',
                'focus-visible:ring-[3px]',
                'focus-visible:ring-blue/50',
                'aria-invalid:border-destructive',
                'aria-invalid:ring-destructive/20',
                'dark:aria-invalid:ring-destructive/40',

                // 'focus:outline-2',
                // 'focus:outline-blue',
                // 'focus:outline-offset-1',
                // 'focus:border-transparent',
                'group-focus-visible/form-input:pt-6.5',
                'group-focus-visible/form-input:pb-1.5',
                'group-not-placeholder-shown/form-input:pt-6.5',
                'group-not-placeholder-shown/form-input:pb-1.5',

                props.class,
            )
        "
    />
</template>
