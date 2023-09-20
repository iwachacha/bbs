<script setup>
  import { mdiMagnify } from '@mdi/js'
  defineProps(['searchData'])
</script>

<template>
  <v-autocomplete
    :items="searchData"
    density="compact"
    :append-inner-icon="mdiMagnify"
    clearable
    persistent-hint
    variant="solo"
  />
</template>