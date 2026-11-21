<script setup lang="ts">
import type { PreloadedFile } from '@/types/preloaded-file';

defineProps<{ image: PreloadedFile }>();
</script>

<template>

    <!--    <img :src="path.resolve('storage', image.path, image.hashed.filename)" :alt="'test'"-->
    <!--    class="aspect-video rounded-t-xl" />-->
</template>

<style scoped></style>
