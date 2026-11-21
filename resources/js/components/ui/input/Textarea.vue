<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { useVModel } from "@vueuse/core"
import { cn } from "@/lib/utils"

const props = defineProps<{
  defaultValue?: string | number
  modelValue?: string | number
  class?: HTMLAttributes["class"]
  cols?: string|number
  rows?: string|number
}>()

const emits = defineEmits<{
  (e: "update:modelValue", payload: string | number): void
}>()

const modelValue = useVModel(props, "modelValue", emits, {
  passive: true,
  defaultValue: props.defaultValue,
})
</script>

<template>
  <textarea
    v-model="modelValue"
    data-slot="input"
    :cols="cols"
    :rows="rows"
    :class="cn(
        'h-9 rounded-xl font-raleway font-medium text-sm text-foreground placeholder:muted-foreground border border-gray-200 px-3 py-2.5',
      'disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50',
      'focus-visible:border-active-border focus-visible:ring-ring focus-visible:ring-2',
      'aria-invalid:border-destructive-border aria-invalid:focus-visible:border-destructive-border aria-invalid:focus-visible:ring-red-600/10 aria-invalid:text-red-600',
      props.class,
    )"
  />
</template>
