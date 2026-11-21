<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import PageContent from '@/components/appLayoutV2/PageContent.vue';
import PageHeader from '@/components/appLayoutV2/PageHeader.vue';
import PageHeaderTop from '@/components/appLayoutV2/PageHeaderTop.vue';
import Card from '@/components/card/Card.vue';
import CardContent from '@/components/card/CardContent.vue';
import CardHeader from '@/components/card/CardHeader.vue';
import DateInput from '@/components/DateInput.vue';
import FormElement from '@/components/FormElement.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayoutV2 from '@/layouts/AppLayoutV2.vue';
import { update } from '@/routes/profile';
import type { UserResource } from '@/types/models/user';

const props = defineProps<{ user: UserResource }>();

const form = useForm<{
    birthdate?: Date;
    phone?: string;
    email?: string;
}>({
    birthdate: !!props.user.birthdate
        ? new Date(props.user.birthdate)
        : undefined,
    phone: props.user.phone ?? undefined,
    email: props.user.email ?? undefined,
});

function onSubmit() {
    form
        .transform((data) => ({...data, phone: data.phone?.substring(0, 18)}))
        .submit(update())
}
</script>

<template>
    <Head title="Редактировать профиль" />

    <AppLayoutV2>
        <template #header>
            <PageHeader>
                <template #top-header>
                    <PageHeaderTop title="Редактировать профиль" />
                </template>
            </PageHeader>
        </template>

        <PageContent>
            <div class="flex flex-col gap-6">
                <Card>
                    <CardHeader
                        title="Личные данные"
                        description="Дата рождения и контакты"
                    />
                    <CardContent>
                        <div class="grid grid-cols-3 gap-4">
                            <FormElement
                                id="birthdate"
                                title="Дата рождения"
                                :error-message="form.errors.birthdate"
                            >
                                <DateInput
                                    v-model="form.birthdate"
                                    id="birthdate"
                                    name="birthdate"
                                    placeholder="ДД.ММ.ГГГГ"
                                    :tabindex="1"
                                    disabled
                                />
                            </FormElement>

                            <FormElement
                                id="phone"
                                title="Телефон"
                                :error-message="form.errors.phone"
                            >
                                <Input
                                    id="phone"
                                    name="phone"
                                    placeholder="+7 (000) 000-00-00"
                                    :tabindex="2"
                                    v-mask="'+7 (###) ###-##-##'"
                                    v-model="form.phone"
                                />
                            </FormElement>

                            <FormElement
                                id="email"
                                title="E-Mail"
                                :error-message="form.errors.email"
                            >
                                <Input
                                    id="email"
                                    name="email"
                                    placeholder="name@example.com"
                                    v-model="form.email"
                                    :tabindex="3"
                                    disabled
                                />
                            </FormElement>
                        </div>
                    </CardContent>
                </Card>

                <div class="flex flex-row items-center justify-end gap-2">
                    <Button
                        variant="secondary"
                        @click="form.resetAndClearErrors()"
                        >Отмена</Button
                    >
                    <Button variant="default" @click="onSubmit()"
                        >Сохранить</Button
                    >
                </div>
            </div>
        </PageContent>
    </AppLayoutV2>
</template>

<style scoped>
@media (max-width: 767px) {
    .grid-cols-3 {
        grid-template-columns: 1fr;
    }

    .grid-cols-3 > * {
        min-width: 0;
    }

    .justify-end {
        flex-direction: column-reverse;
        align-items: stretch;
    }
}
</style>
