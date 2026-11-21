<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowDownToLine } from 'lucide-vue-next';
import PageContent from '@/components/appLayoutV2/PageContent.vue';
import PageHeader from '@/components/appLayoutV2/PageHeader.vue';
import PageHeaderTop from '@/components/appLayoutV2/PageHeaderTop.vue';
import Card from '@/components/card/Card.vue';
import CardContent from '@/components/card/CardContent.vue';
import CardHeader from '@/components/card/CardHeader.vue';
import DateInput from '@/components/DateInput.vue';
import FormElement from '@/components/FormElement.vue';
import SelectInput from '@/components/SelectInput.vue';
import { Button } from '@/components/ui/button';
import { Input, Textarea } from '@/components/ui/input';
import { Switch } from '@/components/ui/switch';
import AppLayoutV2 from '@/layouts/AppLayoutV2.vue';
import { store, update, my } from '@/routes/events';
import type { EnumElement } from '@/types';
import type { EventFullResource } from '@/types/models/event';
import type { UserResource } from '@/types/models/user';

const props = defineProps<{
    event?: EventFullResource;
    creator: UserResource;
    event_levels: EnumElement<string>[];
    activity_directions: EnumElement<string>[];
    youth_policy_directions: EnumElement<string>[];
}>();

const form = useForm({
    main_name: props.event?.main?.name ?? null,
    main_event_level: props.event?.main?.event_level?.value ?? null,
    main_activity_direction:
        props.event?.main?.activity_direction?.value ?? null,
    main_youth_policy_direction:
        props.event?.main?.youth_policy_direction?.value ?? null,

    dates_start_date: !!props.event?.dates?.start_date
        ? new Date(props.event.dates.start_date)
        : null,
    dates_end_date: !!props.event?.dates?.end_date
        ? new Date(props.event.dates.end_date)
        : null,
    dates_start_time: props.event?.dates?.start_time ?? null,

    plan_target_audience: props.event?.plan?.target_audience ?? null,
    plan_description: props.event?.plan?.description ?? null,
    plan_target_smart: props.event?.plan?.target_smart ?? null,
    plan_qualitative_indicators:
        props.event?.plan?.qualitative_indicators ?? null,
    plan_scenario_file: null,
    plan_estimate_file: null,

    announcement_enabled: props.event?.announcement?.enabled ?? false,
    announcement_description: props.event?.announcement?.description ?? null,
    announcement_image_file: null,

    registration_enabled: props.event?.registration?.enabled ?? false,
    registration_end_date: !!props.event?.registration?.end_date
        ? new Date(props.event.registration.end_date)
        : null,
    registration_members_count: props.event?.registration?.members_count ?? 0,
});

function submit() {
    if (!!props.event) {
        form.patch(update(props.event.id).url);
    } else {
        form.post(store().url);
    }
}
</script>

<template>
    <Head
        :title="
            !!props.event
                ? 'Редактирование мероприятия'
                : 'Создание мероприятия'
        "
    />

    <AppLayoutV2>
        <template #header>
            <PageHeader>
                <template #top-header>
                    <PageHeaderTop
                        :title="
                            !!props.event
                                ? 'Редактирование мероприятия'
                                : 'Создание мероприятия'
                        "
                        :back-href="my()"
                    />
                </template>
            </PageHeader>
        </template>

        <PageContent>
            <div class="flex flex-col gap-4">
                <Card>
                    <CardHeader title="Основная информация" />
                    <CardContent>
                        <div class="grid grid-cols-3 gap-4">
                            <FormElement
                                id="main_name"
                                title="Название мероприятия"
                                class="col-span-3"
                                :error-message="form.errors.main_name"
                            >
                                <Input
                                    id="main_name"
                                    type="text"
                                    name="main_name"
                                    v-model="form.main_name"
                                    placeholder="Название мероприятия"
                                    :tabindex="1"
                                />
                            </FormElement>

                            <FormElement
                                id="main_event_level"
                                title="Уровень мероприятия"
                                :error-message="form.errors.main_event_level"
                            >
                                <SelectInput
                                    id="main_event_level"
                                    name="main_event_level"
                                    v-model="form.main_event_level"
                                    :items="
                                        event_levels.map((e) => {
                                            return {
                                                value: e.value,
                                                title: e.display_name,
                                            };
                                        })
                                    "
                                    :tabindex="2"
                                />
                            </FormElement>

                            <FormElement
                                id="main_activity_direction"
                                title="Направление деятельности"
                                :error-message="
                                    form.errors.main_activity_direction
                                "
                            >
                                <SelectInput
                                    id="main_activity_direction"
                                    name="main_activity_direction"
                                    v-model="form.main_activity_direction"
                                    :items="
                                        activity_directions.map((e) => {
                                            return {
                                                value: e.value,
                                                title: e.display_name,
                                            };
                                        })
                                    "
                                    :tabindex="3"
                                />
                            </FormElement>

                            <FormElement
                                id="main_youth_policy_direction"
                                title="Направление молодёжной политики"
                                :error-message="
                                    form.errors.main_youth_policy_direction
                                "
                            >
                                <SelectInput
                                    id="main_youth_policy_direction"
                                    name="main_youth_policy_direction"
                                    v-model="form.main_youth_policy_direction"
                                    :items="
                                        youth_policy_directions.map((e) => {
                                            return {
                                                value: e.value,
                                                title: e.display_name,
                                            };
                                        })
                                    "
                                    :tabindex="4"
                                />
                            </FormElement>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader title="Когда пройдёт мероприятие" />
                    <CardContent>
                        <div class="grid grid-cols-3 gap-4">
                            <FormElement
                                id="dates_start_date"
                                title="Дата проведения"
                                :error-message="form.errors.dates_start_date"
                            >
                                <DateInput
                                    v-model="form.dates_start_date"
                                    id="dates_start_date"
                                    name="dates_start_date"
                                    placeholder="ДД.ММ.ГГГГ"
                                    :tabindex="5"
                                />
                            </FormElement>

                            <div>
                                <FormElement
                                    title="Время начала"
                                    id="dates_start_time"
                                    :error-message="
                                        form.errors.dates_start_time
                                    "
                                >
                                    <Input
                                        id="dates_start_time"
                                        type="time"
                                        name="dates_start_time"
                                        v-model="form.dates_start_time"
                                        placeholder="10:00:00"
                                        step="1"
                                        default-value="10:00:00"
                                        :tabindex="6"
                                    />
                                </FormElement>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader
                        title="План мероприятия"
                        description="Укажите информацию о проведении мероприятия, необходимую для согласования с администрацией"
                    />
                    <CardContent>
                        <div class="grid grid-cols-2 gap-4">
                            <FormElement
                                title="Целевая аудитория"
                                id="plan_target_audience"
                                class="col-span-2"
                                :error-message="
                                    form.errors.plan_target_audience
                                "
                            >
                                <Input
                                    id="plan_target_audience"
                                    type="text"
                                    name="plan_target_audience"
                                    v-model="form.plan_target_audience"
                                    placeholder="Укажите участников, для которых проводится мероприятие"
                                    :tabindex="7"
                                />
                            </FormElement>

                            <FormElement
                                id="plan_description"
                                title="Полное описание"
                                class="col-span-2"
                                :error-message="form.errors.plan_description"
                            >
                                <Textarea
                                    id="plan_description"
                                    type="text"
                                    name="plan_description"
                                    placeholder="Опишите формат, содержание и порядок проведения мероприятия"
                                    v-model="form.plan_description"
                                    class="h-30"
                                    rows="5"
                                    :tabindex="8"
                                />
                            </FormElement>

                            <FormElement
                                id="plan_target_smart"
                                title="Цель мероприятия по SMART"
                                class="col-span-2"
                                :error-message="form.errors.plan_target_smart"
                            >
                                <Textarea
                                    id="plan_target_smart"
                                    type="text"
                                    name="plan_target_smart"
                                    placeholder="Сформулируйте цель мероприятия по методике SMART с указанием ожидаемого результата"
                                    v-model="form.plan_target_smart"
                                    class="h-30"
                                    rows="5"
                                    :tabindex="9"
                                />
                            </FormElement>

                            <FormElement
                                id="plan_qualitative_indicators"
                                title="Качественные показатели"
                                class="col-span-2"
                                :error-message="
                                    form.errors.plan_qualitative_indicators
                                "
                            >
                                <Textarea
                                    id="plan_qualitative_indicators"
                                    type="text"
                                    name="plan_qualitative_indicators"
                                    placeholder="Опишите ожидаемые результаты и значение мероприятия для участников"
                                    v-model="form.plan_qualitative_indicators"
                                    class="h-30"
                                    rows="5"
                                    :tabindex="10"
                                />
                            </FormElement>

                            <FormElement
                                title="Сценарий"
                                id="plan_scenario_file"
                                :error-message="form.errors.plan_scenario_file"
                            >
                                <div class="flex flex-row gap-1">
                                    <Input
                                        id="plan_scenario_file"
                                        type="file"
                                        name="plan_scenario_file"
                                        placeholder="Выберите"
                                        class="w-full"
                                        @input="
                                            (e) => {
                                                form.plan_scenario_file =
                                                    e.target.files[0];
                                            }
                                        "
                                        :tabindex="11"
                                    />

                                    <Button variant="outline">
                                        <ArrowDownToLine /> Шаблон
                                    </Button>
                                </div>
                            </FormElement>

                            <FormElement
                                title="Смета"
                                id="plan_estimate_file"
                                :error-message="form.errors.plan_estimate_file"
                            >
                                <div class="flex flex-row gap-1">
                                    <Input
                                        id="plan_estimate_file"
                                        type="file"
                                        name="plan_estimate_file"
                                        placeholder="Выберите"
                                        class="w-full"
                                        @input="
                                            (e) => {
                                                form.plan_estimate_file =
                                                    e.target.files[0];
                                            }
                                        "
                                        :tabindex="12"
                                    />

                                    <Button variant="outline">
                                        <ArrowDownToLine /> Шаблон
                                    </Button>
                                </div>
                            </FormElement>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader
                        title="Разместить мероприятие в афише"
                        description="Страница мероприятия будет видна всем пользователям"
                    >
                        <template #actions>
                            <Switch v-model="form.announcement_enabled" />
                        </template>
                    </CardHeader>
                    <CardContent v-if="form.announcement_enabled">
                        <div class="grid grid-cols-3 gap-4">
                            <FormElement
                                title="Описание мероприятия"
                                id="announcement_description"
                                class="col-span-3"
                                :error-message="
                                    form.errors.announcement_description
                                "
                            >
                                <Textarea
                                    id="announcement_description"
                                    type="text"
                                    name="announcement_description"
                                    placeholder="Описание мероприятия"
                                    v-model="form.announcement_description"
                                    class="h-60"
                                    :tabindex="13"
                                    rows="10"
                                />
                            </FormElement>

                            <FormElement
                                id="announcement_image_file"
                                title="Обложка 1x1"
                                :error-message="
                                    form.errors.announcement_image_file
                                "
                            >
                                <Input
                                    id="announcement_image_file"
                                    type="file"
                                    name="announcement_image_file"
                                    placeholder="Выберите"
                                    :tabindex="14"
                                    @input="
                                        (e) => {
                                            form.announcement_image_file =
                                                e.target.files[0];
                                        }
                                    "
                                />
                            </FormElement>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader
                        title="Регистрация через платформу"
                        description="Укажите параметры регистрации участников на мероприятие"
                    >
                        <template #actions>
                            <Switch v-model="form.registration_enabled" />
                        </template>
                    </CardHeader>
                    <CardContent v-if="form.registration_enabled">
                        <div class="grid grid-cols-2 gap-4">
                            <FormElement
                                id="registration_end_date"
                                title="Последний день регистрации"
                                :error-message="
                                    form.errors.registration_end_date
                                "
                            >
                                <DateInput
                                    v-model="form.registration_end_date"
                                    id="registration_end_date"
                                    name="registration_end_date"
                                    placeholder="ДД.ММ.ГГГГ"
                                    :tabindex="15"
                                />
                            </FormElement>

                            <FormElement
                                id="registration_members_count"
                                title="Лимит регистрации"
                                :error-message="
                                    form.errors.registration_members_count
                                "
                            >
                                <SelectInput
                                    id="registration_members_count"
                                    name="registration_members_count"
                                    v-model="form.registration_members_count"
                                    :items="[
                                        { value: 0, title: 'Неограничено' },
                                        { value: 10, title: '10' },
                                        { value: 20, title: '20' },
                                        { value: 30, title: '30' },
                                        { value: 40, title: '40' },
                                        { value: 50, title: '50' },
                                        { value: 60, title: '60' },
                                        { value: 70, title: '70' },
                                        { value: 80, title: '80' },
                                        { value: 90, title: '90' },
                                        { value: 100, title: '100' },
                                        { value: 125, title: '125' },
                                        { value: 150, title: '150' },
                                        { value: 175, title: '175' },
                                        { value: 200, title: '200' },
                                    ]"
                                    :tabindex="16"
                                />
                            </FormElement>
                        </div>
                    </CardContent>
                </Card>

                <div class="flex flex-row items-center justify-end gap-2">
                    <Button :as="Link" :href="my()" variant="secondary">Отмена</Button>
                    <Button variant="default" type="button" @click="submit"
                        >{{!!props.event ? 'Сохранить мероприятие' : 'Создать мероприятие'}}</Button
                    >
                </div>
            </div>
        </PageContent>
    </AppLayoutV2>
</template>

<style scoped>
@media (max-width: 767px) {
    .grid-cols-3,
    .grid-cols-2 {
        grid-template-columns: 1fr;
    }

    .grid-cols-3 > *,
    .grid-cols-2 > * {
        grid-column: auto;
        min-width: 0;
    }

    .justify-end {
        flex-direction: column-reverse;
        align-items: stretch;
    }
}
</style>
