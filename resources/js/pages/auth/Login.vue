<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthBase from '@/layouts/AuthLayout.vue';
import { store } from '@/routes/login';
import { Form, Head } from '@inertiajs/vue3';

defineProps<{
    status?: string;
}>();
</script>

<template>
    <AuthBase title="ورود به حساب کاربری" description="برای ادامه شماره موبایل و رمز خود را وارد کنید">
        <Head title="ورود" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <Form v-bind="store.form()" :reset-on-success="['password']" v-slot="{ hasErrors, errors, processing }" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="form-input-group">
                    <div class="group/form-input">
                        <Input
                            id="mobile"
                            type="text"
                            name="mobile"
                            autocomplete="mobile"
                            placeholder="موبایل"
                            dir="ltr"
                            :tabindex="1"
                            :aria-invalid="errors.mobile ? 'true' : 'false'"
                            required
                            autofocus
                        />
                        <Label for="email">موبایل</Label>
                    </div>
                    <div class="group/form-input">
                        <Input
                            id="password"
                            type="password"
                            name="password"
                            autocomplete="password"
                            placeholder="رمز عبور"
                            dir="ltr"
                            :tabindex="2"
                            :aria-invalid="errors.password ? 'true' : 'false'"
                            required
                        />
                        <Label for="password">رمز عبور</Label>
                    </div>
                </div>

                <div v-if="hasErrors">
                    <InputError :message="errors.email" />
                    <InputError :message="errors.password" />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3">
                        <Checkbox id="remember" name="remember" :tabindex="3" />
                        <span>مرا به خاطر بسپار</span>
                    </Label>
                </div>

                <Button type="submit" size="lg" class="w-full" data-test="login-button" :tabindex="3" :disabled="processing">
                    <Spinner v-if="processing" />
                    ورود
                </Button>
            </div>
        </Form>
    </AuthBase>
</template>
