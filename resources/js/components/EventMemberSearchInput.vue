<script setup lang="ts">
import { useVModel } from '@vueuse/core';
import { ChevronsUpDownIcon, CheckIcon, Search } from 'lucide-vue-next';
import { Primitive } from 'reka-ui';
import { onMounted, ref } from 'vue';
import { Button } from '@/components/ui/button';
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
} from '@/components/ui/command';
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from '@/components/ui/input-group';
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { search } from '@/routes/api/events/members';
import type { EventMemberResource } from '@/types/models/event/member';

const props = defineProps<{
    event_id: number;
    modelValue?: undefined | null | number;
}>();
const emits = defineEmits<{
    (e: 'update:modelValue', payload?: undefined | null | number): void;
}>();

const open = ref(false);
const members = ref<EventMemberResource[]>([]);
const vModel = useVModel(props, 'modelValue', emits);

function searchFn(searchQuery?: string) {
    fetch(
        search(props.event_id).url +
            '?' +
            new URLSearchParams({ search: searchQuery ?? '' }),
        { method: search(props.event_id).method },
    )
        .then((response) => response.json())
        .then((data) => {
            members.value = data;
        });
}

onMounted(() => {
    if (!!vModel.value) {
        fetch(
            search(props.event_id).url +
                '?' +
                new URLSearchParams({
                    selected: vModel.value!.toString(),
                }),
            { method: search(props.event_id).method },
        )
            .then((response) => response.json())
            .then((data) => {
                members.value = data;
            });
    }
});
</script>

<template>
    <Popover v-model:open="open">
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                role="combobox"
                :aria-expanded="open"
                class="w-full justify-between"
            >
                {{
                    !!vModel
                        ? members.find((e) => Number(e.id) === Number(vModel))
                              ?.user?.full_name
                        : 'Выберите пользователя'
                }}
                <ChevronsUpDownIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
            </Button>
        </PopoverTrigger>

        <PopoverContent class="p-0">
            <Command>
                <InputGroup class="border-none outline-none">
                    <InputGroupInput
                        placeholder="Поиск пользователя..."
                        @update:modelValue="searchFn"
                    />
                    <InputGroupAddon>
                        <Search class="mr-2" />
                    </InputGroupAddon>
                </InputGroup>
                <!--                <CommandInput-->
                <!--                    placeholder="Поиск пользователя..."-->
                <!--                    @input="(e) => searchFn(e.target.value)"-->
                <!--                />-->

                <CommandList>
                    <Primitive
                        v-if="members.length <= 0"
                        data-slot="command-empty"
                        :class="cn('py-6 text-center text-sm')"
                    >
                        Пользователь не найден
                    </Primitive>
                    <!--                    <span-->
                    <!--                        v-if=""-->
                    <!--                        data-slot="command-empty"-->
                    <!--                        class="py-6 text-center text-sm"-->
                    <!--                    >-->
                    <!--                    </span>-->
                    <!--                    <CommandEmpty>Пользователь не найден</CommandEmpty>-->
                    <CommandGroup>
                        <CommandItem
                            v-for="member in members"
                            :key="member.id"
                            :value="member.id"
                            @select="
                                () => {
                                    vModel = member.id;
                                    open = false;
                                }
                            "
                        >
                            <CheckIcon
                                :class="
                                    cn(
                                        'mr-2 h-4 w-4',
                                        Number(vModel) === Number(member.id)
                                            ? 'opacity-100'
                                            : 'opacity-0',
                                    )
                                "
                            />
                            {{ member.user?.full_name }}
                        </CommandItem>
                    </CommandGroup>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>
</template>

<style scoped></style>
