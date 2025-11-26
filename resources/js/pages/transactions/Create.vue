<script setup lang="ts">
import TagController from '@/actions/App/Http/Controllers/TagController';
import TransactionController from '@/actions/App/Http/Controllers/TransactionController';
import ColorPicker from '@/components/ColorPicker.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { Drawer, DrawerContent, DrawerDescription, DrawerFooter, DrawerHeader, DrawerTitle, DrawerTrigger } from '@/components/ui/drawer';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Spinner } from '@/components/ui/spinner';
import { Textarea } from '@/components/ui/textarea';
import { ToggleGroup, ToggleGroupItem } from '@/components/ui/toggle-group';
import AppLayout from '@/layouts/AppLayout.vue';
import { getContrastColor } from '@/lib/utils';
import { dashboard } from '@/routes';
import { create } from '@/routes/transactions';
import type { BreadcrumbItem, Tag } from '@/types';
import type { Form as InertiaForm } from '@inertiajs/vue3';
import { Form, Head, router } from '@inertiajs/vue3';
import { DateFormatter, DateValue, getLocalTimeZone, PersianCalendar, toCalendar, today } from '@internationalized/date';
import { BanknoteArrowDownIcon, BanknoteArrowUpIcon, CalendarIcon, CheckIcon, TagsIcon } from 'lucide-vue-next';
import { CheckboxGroupRoot, CheckboxIndicator, CheckboxRoot } from 'reka-ui';
import { computed, Ref, ref } from 'vue';

const props = defineProps<{
    tags: Tag[];
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'داشبورد',
        href: dashboard().url,
    },
    {
        title: 'تراکنش جدید',
        href: create().url,
    },
];

const formRef = ref<InstanceType<typeof InertiaForm> | null>(null);
const rawAmount = ref<number | null>(null);
const displayAmount = ref<string>('');
const type = ref<'INCOME' | 'EXPENSE'>('INCOME');
const date = ref(today(getLocalTimeZone())) as Ref<DateValue>;
const placeholder = ref(toCalendar(today(getLocalTimeZone()), new PersianCalendar())) as Ref<DateValue>;
const df = new DateFormatter('fa-IR', { dateStyle: 'long' });
const selectedTags = ref<Tag[]>([]);
const newTagColor = ref<string>();
const isCalenderDrawerOpen = ref<boolean>(false);
const isTagDrawerOpen = ref<boolean>(false);

const incomeExpenseLabel = computed(() => (type.value == 'INCOME' ? 'دریافت' : 'پرداخت'));
const availableTags = computed(() => props.tags);

const formatAmount = (value: string) => {
    const raw = value.replace(/,/g, '');
    if (!/^\d*$/.test(raw)) return displayAmount.value;

    return raw.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
};
const unformatAmount = (value: string) => value.replace(/,/g, '');
const onAmountInput = (e: Event) => {
    const target = e.target as HTMLInputElement;
    const cleaned = target.value.replace(/[^0-9]/g, '');
    displayAmount.value = formatAmount(cleaned);
};
const onAmountBlur = (e: Event) => {
    const target = e.target as HTMLInputElement;
    rawAmount.value = parseInt(unformatAmount(target.value), 10);
};
const handleSuccess = () => {
    isTagDrawerOpen.value = false;
    router.reload({ only: ['tags'] });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="تراکنش جدید" />

        <div class="flex flex-col space-y-6 px-4 py-6 md:mx-auto md:max-w-md">
            <Heading title="تراکنش جدید" />
            <Form
                v-bind="TransactionController.store.form()"
                v-slot="{ errors, processing }"
                ref="formRef"
                :transform="
                    (data) => ({
                        ...data,
                        ...(rawAmount && { amount: rawAmount }),
                        ...(date && { date: date.toString() }),
                        ...(selectedTags && { tags: selectedTags }),
                    })
                "
                class="flex flex-col gap-6"
            >
                <div class="grid gap-4">
                    <div class="group/form-input">
                        <ToggleGroup v-model="type" name="type" variant="outline" type="single" size="lg" dir="rtl" required>
                            <ToggleGroupItem class="w-full" value="INCOME" aria-label="income">
                                <BanknoteArrowDownIcon class="size-5" />
                                <span class="text-sm">درآمد</span>
                            </ToggleGroupItem>
                            <ToggleGroupItem class="w-full" value="EXPENSE" aria-label="expense">
                                <BanknoteArrowUpIcon class="size-5" />
                                <span class="text-sm">هزینه</span>
                            </ToggleGroupItem>
                        </ToggleGroup>
                        <InputError :message="errors.type" />
                    </div>

                    <div class="group/form-input">
                        <Input
                            id="title"
                            type="text"
                            name="title"
                            placeholder="عنوان"
                            autocomplete="off"
                            :aria-invalid="errors.title ? 'true' : 'false'"
                            required
                        />
                        <Label for="title">عنوان</Label>
                        <InputError :message="errors.title" />
                    </div>

                    <div class="group/form-input">
                        <Input
                            id="price"
                            class="pl-16"
                            type="text"
                            inputmode="numeric"
                            placeholder="مبلغ"
                            autocomplete="off"
                            :aria-invalid="errors.amount ? 'true' : 'false'"
                            v-model="displayAmount"
                            @input="onAmountInput"
                            @blur="onAmountBlur"
                            required
                        />
                        <Label for="price">مبلغ</Label>
                        <InputError :message="errors.amount" />
                        <span :class="['absolute left-5 -translate-y-1/2 text-sm text-muted-foreground', errors.amount ? 'top-7' : 'top-1/2']"
                            >تومان</span
                        >
                    </div>

                    <div class="group/form-input">
                        <Drawer v-model:open="isCalenderDrawerOpen">
                            <DrawerTrigger as-child>
                                <Button variant="outline" size="lg" :aria-invalid="errors.date ? 'true' : 'false'">
                                    <CalendarIcon class="ml-auto size-5 text-muted-foreground" />
                                    <span class="grow">{{ date ? df.format(date.toDate(getLocalTimeZone())) : 'انتخاب تاریخ' }}</span>
                                </Button>
                            </DrawerTrigger>
                            <DrawerContent>
                                <div class="flex flex-col items-center justify-center md:mx-auto md:w-auto">
                                    <DrawerHeader class="flex w-full flex-col items-start justify-between rtl:!text-right">
                                        <DrawerTitle>تاریخ تراکنش</DrawerTitle>
                                        <DrawerDescription>انتخاب تاریخی که تراکنش در آن انجام شده است</DrawerDescription>
                                    </DrawerHeader>
                                    <Calendar
                                        v-model="date"
                                        v-model:placeholder="placeholder"
                                        class="w-full max-w-xs"
                                        locale="fa-IR"
                                        dir="rtl"
                                        initial-focus
                                        @update:model-value="
                                            (value) => {
                                                if (value) {
                                                    date = value;
                                                    isCalenderDrawerOpen = false;
                                                }
                                            }
                                        "
                                    />
                                    <DrawerFooter class="mt-2"> </DrawerFooter>
                                </div>
                            </DrawerContent>
                        </Drawer>
                        <InputError :message="errors.date" />
                    </div>

                    <div class="group/form-input">
                        <Input
                            id="payee_payer"
                            type="text"
                            name="payee_payer"
                            autocomplete="off"
                            :placeholder="`${incomeExpenseLabel} کننده`"
                            :aria-invalid="errors.payee_payer ? 'true' : 'false'"
                            required
                        />
                        <Label for="payee_payer">{{ `${incomeExpenseLabel} کننده` }}</Label>
                        <InputError :message="errors.payee_payer" />
                    </div>

                    <div class="group/form-input">
                        <Select dir="rtl" name="payment_method" :aria-invalid="errors.payment_method ? 'true' : 'false'" required>
                            <SelectTrigger class="h-auto px-4.5 py-4" dir="rtl">
                                <SelectValue :placeholder="`روش ${incomeExpenseLabel}`" dir="rtl" />
                            </SelectTrigger>
                            <SelectContent class="min-w-full" dir="rtl">
                                <SelectGroup class="w-(--reka-popper-anchor-width)" dir="rtl">
                                    <SelectLabel>{{ `روش ${incomeExpenseLabel}` }}</SelectLabel>
                                    <SelectItem value="POSE">کارتخوان</SelectItem>
                                    <SelectItem value="CARD">کارت به کارت</SelectItem>
                                    <SelectItem value="ONLINE">درگاه پرداخت آنلاین</SelectItem>
                                    <SelectItem value="CASH">نقد</SelectItem>
                                    <SelectItem value="BANK">انتقال بین بانکی (پایا، سانتا، پل و ...)</SelectItem>
                                    <SelectItem value="CHECK">چک</SelectItem>
                                    <SelectItem value="OTHERS">سایر موارد</SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="errors.payment_method" />
                    </div>

                    <div class="mt-4 grid gap-4">
                        <div class="flex w-full items-center justify-between rtl:!text-right">
                            <div class="w-full">
                                <h3 class="text-md leading-none font-semibold tracking-tight">تگ ها</h3>
                                <span class="text-xs text-muted-foreground">انتخاب تگ برای تراکنش</span>
                            </div>
                            <Button type="button" variant="secondary" @click="isTagDrawerOpen = true">
                                <TagsIcon />
                                <span>تگ جدید</span>
                            </Button>
                        </div>
                        <CheckboxGroupRoot v-model="selectedTags" class="flex w-full flex-wrap items-center gap-2" dir="rtl">
                            <CheckboxRoot v-for="item in availableTags" v-slot="{ state }" :key="item.id" :value="item.id">
                                <Button type="button" variant="outline" class="relative w-full justify-between overflow-hidden">
                                    <CheckboxIndicator class="z-10" :style="state ? { color: getContrastColor(item.color) } : {}">
                                        <CheckIcon />
                                    </CheckboxIndicator>
                                    <CheckboxIndicator class="absolute inset-0 z-0 size-full" :style="{ backgroundColor: item.color }" />
                                    <span v-if="!state" class="size-2 rounded-full" :style="{ backgroundColor: item.color }" />
                                    <span class="z-10" :style="state ? { color: getContrastColor(item.color) } : {}">{{ item.name }}</span>
                                </Button>
                            </CheckboxRoot>
                        </CheckboxGroupRoot>
                        <InputError :message="errors.tags" />
                    </div>

                    <div class="group/form-input">
                        <Input
                            id="reference_number"
                            type="number"
                            inputmode="numeric"
                            name="reference_number"
                            placeholder="شماره پیگیری"
                            autocomplete="off"
                            :aria-invalid="errors.reference_number ? 'true' : 'false'"
                        />
                        <Label for="reference_number">شماره پیگیری</Label>
                        <InputError :message="errors.reference_number" />
                    </div>

                    <div class="group/form-input">
                        <Textarea
                            id="description"
                            type="text"
                            name="description"
                            placeholder="توضیحات"
                            :aria-invalid="errors.description ? 'true' : 'false'"
                        />
                        <Label for="description">توضیحات</Label>
                        <InputError :message="errors.description" />
                    </div>

                    <div class="mt-4 flex items-center justify-center">
                        <Button type="submit" size="lg" class="w-full" :disabled="processing" data-test="submit-button">
                            <Spinner v-if="processing" />
                            <span>ثبت</span>
                        </Button>
                    </div>
                </div>
            </Form>

            <Drawer v-model:open="isTagDrawerOpen">
                <DrawerContent>
                    <Form
                        v-bind="TagController.store.form()"
                        v-slot="{ errors, processing }"
                        class="flex flex-col items-center justify-center md:mx-auto md:w-auto"
                        :transform="
                            (data) => ({
                                ...data,
                                ...(newTagColor && { color: newTagColor }),
                            })
                        "
                        @success="handleSuccess"
                    >
                        <DrawerHeader class="flex w-full flex-col items-start justify-between rtl:!text-right">
                            <DrawerTitle>تگ جدید</DrawerTitle>
                            <DrawerDescription>ساخت تگ جدید برای دسته بندی تراکنش ها</DrawerDescription>
                        </DrawerHeader>
                        <div class="flex w-full flex-col gap-4 p-4">
                            <div class="group/form-input">
                                <Input
                                    id="name"
                                    type="text"
                                    name="name"
                                    placeholder="نام"
                                    autocomplete="off"
                                    :aria-invalid="errors.name ? 'true' : 'false'"
                                />
                                <Label for="label">نام تگ</Label>
                                <InputError :message="errors.name" />
                            </div>
                            <div class="group/form-input">
                                <ColorPicker v-model="newTagColor" />
                                <InputError :message="errors.color" />
                            </div>
                        </div>
                        <DrawerFooter class="w-full">
                            <Button type="submit" size="lg" :disabled="processing" data-test="submit-button">
                                <Spinner v-if="processing" />
                                <span>ثبت</span>
                            </Button>
                        </DrawerFooter>
                    </Form>
                </DrawerContent>
            </Drawer>
        </div>
    </AppLayout>
</template>
