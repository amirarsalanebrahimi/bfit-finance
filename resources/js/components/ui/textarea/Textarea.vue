<script setup lang="ts">
import { cn } from '@/lib/utils';
import { useVModel } from '@vueuse/core';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
    defaultValue?: string | number;
    modelValue?: string | number;
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
    <textarea
        v-model="modelValue"
        data-slot="textarea"
        :class="
            cn(
                'peer/input',
                'flex',
                'field-sizing-content',
                'min-h-32',
                'w-full',
                'rounded-md',
                'border',
                'border-input',
                'bg-transparent',
                'px-4.5',
                'py-4',
                'text-base',
                'shadow-xs',
                'transition-[color,box-shadow]',
                'outline-none',
                'placeholder-transparent',
                'focus-visible:border-blue',
                'focus-visible:ring-[3px]',
                'focus-visible:ring-blue/50',
                'disabled:cursor-not-allowed',
                'disabled:opacity-50',
                'aria-invalid:border-destructive',
                'aria-invalid:ring-destructive/20',
                'md:text-sm',
                'dark:bg-input/30',
                'dark:aria-invalid:ring-destructive/40',

                'group-focus-visible/form-input:pt-6.5',
                'group-focus-visible/form-input:pb-1.5',
                'group-not-placeholder-shown/form-input:pt-6.5',
                'group-not-placeholder-shown/form-input:pb-1.5',

                props.class,
            )
        "
    />
</template>
