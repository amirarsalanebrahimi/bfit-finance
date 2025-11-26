<script setup lang="ts">
import { cn } from '@/lib/utils';
import { Label, type LabelProps } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

const props = defineProps<LabelProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});
</script>

<template>
    <Label
        data-slot="label"
        v-bind="delegatedProps"
        :class="
            cn(
                'flex',
                'items-center',
                'gap-2',
                'text-sm',
                'leading-none',
                'font-medium',
                'select-none',

                'group-data-[disabled=true]/form-input:opacity-50',

                'peer-placeholder-shown/input:top-[20px]',
                'peer-placeholder-shown/input:text-sm',
                'peer-placeholder-shown/input:cursor-text',
                'peer-placeholder-shown/input:text-muted-foreground',

                'peer-not-placeholder-shown/input:top-3',
                'peer-not-placeholder-shown/input:text-xs',
                'peer-not-placeholder-shown/input:text-muted-foreground',

                'peer-focus-visible/input:top-3',
                'peer-focus-visible/input:text-xs',
                'peer-focus-visible/input:text-muted-foreground',

                'peer-disabled/input:opacity-50',
                'peer-disabled/input:cursor-not-allowed',

                'peer-aria-[invalid=true]/input:!text-destructive',
                props.class,
            )
        "
    >
        <slot />
    </Label>
</template>
