<script setup>
  import { mdiHelpCircleOutline } from '@mdi/js'

  defineProps(['icon', 'title', 'tipText'])
</script>

<template>
  <v-sheet rounded="0" color="secondary" class="pb-10 mx-auto">

    <v-card-title class="my-7 ms-sm-3 ms-md-7 text-h5 text-medium-emphasis d-flex">
        <v-icon :icon="icon" class="me-2" size="small" />
        <h3>{{ title }}</h3>
        <v-tooltip location="bottom" v-if="tipText" style="white-space: pre;">
          <template v-slot:activator="{ props }">
            <v-icon
              v-bind="props"
              :icon="mdiHelpCircleOutline"
              class="ms-3 text-disabled"
              size="small"
            />
          </template>
          <span v-text="tipText" />
        </v-tooltip>
    </v-card-title>

    <div class="mt-5 px-5 px-sm-10 px-md-16 py-0">
      <slot />
    </div>

  </v-sheet>
</template>