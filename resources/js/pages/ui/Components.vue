<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { parseDate } from '@internationalized/date';
import { ref } from 'vue';
import DateInput from '@/components/DateInput.vue';
import InputError from '@/components/InputError.vue';
import InputHelp from '@/components/InputHelp.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import Color from '@/pages/ui/components/Color.vue';
import Container from '@/pages/ui/components/Container.vue';

const date = ref<null|string>((new Date('01.04.2026')).toISOString());
</script>

<template>
    <Head title="UI - Components" />

    <div class="flex flex-col gap-4 p-4">
        <Container title="Colors">
            <Container title="Gray" type="horizontal">
                <Color class="bg-gray-50" />
                <Color class="bg-gray-100" />
                <Color class="bg-gray-200" />
                <Color class="bg-gray-300" />
                <Color class="bg-gray-400" />
                <Color class="bg-gray-500" />
                <Color class="bg-gray-600" />
                <Color class="bg-gray-700" />
                <Color class="bg-gray-800" />
                <Color class="bg-gray-900" />
                <Color class="bg-gray-950" />
            </Container>

            <Container title="Blue" type="horizontal">
                <Color class="bg-blue-50" />
                <Color class="bg-blue-100" />
                <Color class="bg-blue-200" />
                <Color class="bg-blue-300" />
                <Color class="bg-blue-400" />
                <Color class="bg-blue-500" />
                <Color class="bg-blue-600" />
                <Color class="bg-blue-700" />
                <Color class="bg-blue-800" />
                <Color class="bg-blue-900" />
                <Color class="bg-blue-950" />
            </Container>

            <Container title="Red" type="horizontal">
                <Color class="bg-red-50" />
                <Color class="bg-red-100" />
                <Color class="bg-red-200" />
                <Color class="bg-red-300" />
                <Color class="bg-red-400" />
                <Color class="bg-red-500" />
                <Color class="bg-red-600" />
                <Color class="bg-red-700" />
                <Color class="bg-red-800" />
                <Color class="bg-red-900" />
                <Color class="bg-red-950" />
            </Container>

            <Container title="Yellow" type="horizontal">
                <Color class="bg-yellow-50" />
                <Color class="bg-yellow-100" />
                <Color class="bg-yellow-200" />
                <Color class="bg-yellow-300" />
                <Color class="bg-yellow-400" />
                <Color class="bg-yellow-500" />
                <Color class="bg-yellow-600" />
                <Color class="bg-yellow-700" />
                <Color class="bg-yellow-800" />
                <Color class="bg-yellow-900" />
                <Color class="bg-yellow-950" />
            </Container>

            <Container title="Green" type="horizontal">
                <Color class="bg-green-50" />
                <Color class="bg-green-100" />
                <Color class="bg-green-200" />
                <Color class="bg-green-300" />
                <Color class="bg-green-400" />
                <Color class="bg-green-500" />
                <Color class="bg-green-600" />
                <Color class="bg-green-700" />
                <Color class="bg-green-800" />
                <Color class="bg-green-900" />
                <Color class="bg-green-950" />
            </Container>
        </Container>

        <Container title="Buttons">
            <Container title="Default (Primary)" type="horizontal">
                <Button variant="default">Button</Button>
                <Button variant="default" disabled>Disables</Button>
            </Container>

            <Container title="Secondary" type="horizontal">
                <Button variant="secondary">Button</Button>
                <Button variant="secondary" disabled>Disables</Button>
            </Container>

            <Container title="Destructive" type="horizontal">
                <Button variant="destructive">Button</Button>
                <Button variant="destructive" disabled>Disables</Button>
            </Container>

            <Container title="Outline" type="horizontal">
                <Button variant="outline">Button</Button>
                <Button variant="outline" disabled>Disables</Button>
            </Container>

            <Container title="Ghost" type="horizontal">
                <Button variant="ghost">Button</Button>
                <Button variant="ghost" disabled>Disables</Button>
            </Container>

            <Container title="Link" type="horizontal">
                <Button variant="link">Button</Button>
                <Button variant="link" disabled>Disables</Button>
            </Container>
        </Container>

        <Container title="Inputs">
            <Label for="inp-text" title="Label">Label</Label>
            <Input id="inp-text" placeholder="Placeholder"></Input>
            <Input id="inp-text-invalid" placeholder="Placeholder" aria-invalid="true"></Input>
            <InputHelp message="Help message"/>
            <InputError message="Error message"/>
            <Input id="inp-text-disable" placeholder="Placeholder" disabled></Input>

            <DateInput :model-value="parseDate(date ?? '')" @update:model-value="(v) => { date = v ? `${v?.day}.${v?.month}.${v?.year}` : null;}"/>
        </Container>
    </div>
</template>

<style scoped></style>
