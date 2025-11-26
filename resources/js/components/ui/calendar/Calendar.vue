<script lang="ts" setup>
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import type { CalendarRootEmits, CalendarRootProps } from 'reka-ui';
import { CalendarRoot, useForwardPropsEmits } from 'reka-ui';
import type { HTMLAttributes } from 'vue';
import {
    CalendarCell,
    CalendarCellTrigger,
    CalendarGrid,
    CalendarGridBody,
    CalendarGridHead,
    CalendarGridRow,
    CalendarHeadCell,
    CalendarHeader,
    CalendarHeading,
    CalendarNextButton,
    CalendarPrevButton,
} from '.';

const props = defineProps<CalendarRootProps & { class?: HTMLAttributes['class'] }>();

const emits = defineEmits<CalendarRootEmits>();

const delegatedProps = reactiveOmit(props, 'class');

const forwarded = useForwardPropsEmits(delegatedProps, emits);
</script>

<template>
    <CalendarRoot v-slot="{ grid, weekDays }" :class="cn('p-3', props.class)" v-bind="forwarded">
        <CalendarHeader>
            <CalendarPrevButton />
            <CalendarHeading />
            <CalendarNextButton />
        </CalendarHeader>

        <div class="mt-4 flex flex-col gap-y-4 sm:flex-row sm:gap-x-4 sm:gap-y-0">
            <CalendarGrid v-for="month in grid" :key="month.value.toString()">
                <CalendarGridHead class="w-full">
                    <CalendarGridRow class="w-full">
                        <CalendarHeadCell v-for="day in weekDays" :key="day" class="w-full">
                            {{ day }}
                        </CalendarHeadCell>
                    </CalendarGridRow>
                </CalendarGridHead>
                <CalendarGridBody>
                    <CalendarGridRow v-for="(weekDates, index) in month.rows" :key="`weekDate-${index}`" class="mt-2 w-full">
                        <CalendarCell v-for="weekDate in weekDates" :key="weekDate.toString()" :date="weekDate" class="aspect-square size-full">
                            <CalendarCellTrigger :day="weekDate" :month="month.value" class="aspect-square size-full" />
                        </CalendarCell>
                    </CalendarGridRow>
                </CalendarGridBody>
            </CalendarGrid>
        </div>
    </CalendarRoot>
</template>
