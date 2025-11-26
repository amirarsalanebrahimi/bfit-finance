<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { useVModel } from '@vueuse/core';
import { ref } from 'vue';

const props = defineProps<{
    modelValue?: string;
    class?: string;
}>();

const emits = defineEmits<{
    (e: 'update:modelValue', payload: string): void;
}>();

const color = useVModel(props, 'modelValue', emits, {
    passive: true,
});

const open = ref(false);

// Validate and format hex color
const handleTextInput = (value: string | number) => {
    const strValue = String(value);
    if (/^#[0-9A-F]{6}$/i.test(strValue)) {
        color.value = strValue;
    }
};
</script>

<template>
    <Popover v-model:open="open">
        <PopoverTrigger as-child>
            <div :class="cn('relative flex cursor-pointer gap-2', props.class)" @click="open = true">
                <div class="pointer-events-none size-14 basis-[60%] rounded-md border border-input" :style="{ backgroundColor: color }" />
                <div class="group/form-input basis-[40%]">
                    <Input
                        placeholder="#000000"
                        class="uppercase"
                        :model-value="color"
                        @update:model-value="handleTextInput"
                        @click.stop="open = true"
                    />
                    <Label for="label">رنگ تگ</Label>
                </div>
            </div>
        </PopoverTrigger>
        <PopoverContent class="w-(--reka-popper-anchor-width) p-3" align="start">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <input v-model="color" id="color" name="color" type="color" class="h-10 w-full" />
                </div>

                <div class="space-y-2">
                    <div class="grid grid-cols-8 gap-2">
                        <button
                            v-for="preset in [
                                '#000000',
                                '#ffffff',
                                '#ef4444',
                                '#f97316',
                                '#f59e0b',
                                '#84cc16',
                                '#10b981',
                                '#06b6d4',
                                '#3b82f6',
                                '#6366f1',
                                '#8b5cf6',
                                '#ec4899',
                                '#64748b',
                                '#78716c',
                                '#dc2626',
                                '#65a30d',
                            ]"
                            :key="preset"
                            type="button"
                            class="size-8 rounded border border-input shadow-sm transition-transform hover:scale-110"
                            :style="{ backgroundColor: preset }"
                            @click="color = preset"
                        />
                    </div>
                </div>
            </div>
        </PopoverContent>
    </Popover>
</template>
