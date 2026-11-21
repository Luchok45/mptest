<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { useVModel } from "@vueuse/core"
import { cn } from "@/lib/utils"

const props = defineProps<{
  defaultValue?: string | number
  modelValue?: string | number
  class?: HTMLAttributes["class"]
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
  <input
    v-model="modelValue"
    data-slot="input"
    :class="cn(
        'h-9 rounded-xl font-raleway font-medium text-sm text-foreground placeholder:muted-foreground border border-gray-200 px-3 py-2.5',
      'disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50',
      'focus-visible:border-active-border focus-visible:ring-ring focus-visible:ring-2',
      'aria-invalid:border-destructive-border aria-invalid:focus-visible:border-destructive-border aria-invalid:focus-visible:ring-red-600/10 aria-invalid:text-red-600',
      'file:text-muted-foreground file:text-sm',
      // 'file:text-foreground selection:bg-primary selection:text-primary-foreground w-full min-w-0 shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium',
      // 'file:text-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm',
      // 'focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]',
      // 'aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive',
      props.class,
    )"
  >
</template>
