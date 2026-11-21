<script setup lang="ts">
import type { TabsListProps } from "reka-ui"
import type { HTMLAttributes } from "vue"
import { reactiveOmit } from "@vueuse/core"
import { TabsList } from "reka-ui"
import { cn } from "@/lib/utils"

const props = defineProps<TabsListProps & { class?: HTMLAttributes["class"] }>()

const delegatedProps = reactiveOmit(props, "class")
</script>

<template>
  <TabsList
    data-slot="tabs-list"
    v-bind="delegatedProps"
    :class="cn(
      'inline-flex w-fit items-center justify-center gap-6',
      // 'text-muted-foreground inline-flex h-9 w-fit items-center justify-center rounded-lg p-[3px]',
      // 'bg-muted text-muted-foreground inline-flex h-9 w-fit items-center justify-center rounded-lg p-[3px]',
      // 'border-b border-gray-200 text-muted-foreground inline-flex h-9 w-fit items-center justify-center p-[3px]',
      props.class,
    )"
  >
    <slot />
  </TabsList>
</template>
