<script setup>
  import { mdiHelpCircleOutline } from '@mdi/js'
</script>

<template>
  <v-select
    clearable
    density="compact"
    variant="underlined"
    persistent-hint
    class="mb-1"
  >
    <template v-slot:prepend>
      <v-tooltip location="bottom">
        <template v-slot:activator="{ props }">
          <v-icon v-bind="props" :icon="mdiHelpCircleOutline"></v-icon>
        </template>
        <slot />
      </v-tooltip>
    </template>
  </v-select>
</template>