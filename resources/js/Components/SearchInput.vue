<script setup>
  import { mdiMagnify, mdiHelpCircleOutline } from '@mdi/js'
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
  >
    <template v-slot:prepend-inner>
      <v-tooltip location="bottom">
        <template v-slot:activator="{ props }">
          <v-icon v-bind="props" :icon="mdiHelpCircleOutline"></v-icon>
        </template>
        <slot />
      </v-tooltip>
    </template>
  </v-autocomplete>
</template>