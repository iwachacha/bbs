<script setup>
  import { mdiHelpCircleOutline } from '@mdi/js'

  defineProps(['icon', 'title', 'subtitle'])
</script>

<template>
  <v-sheet rounded="0" color="secondary" class="mb-16 mx-auto">

    <v-card-title
      class="mx-n1 mt-7 mx-md-5 text-h6 text-sm-h5 text-medium-emphasis d-flex"
      style="white-space: normal; line-height: normal;"
    >
      <v-icon :icon="icon" class="me-2" size="34" />
      <h3>{{ title }}</h3>

      <div v-if="subtitle" class="d-sm-none ms-2">
        <v-tooltip location="bottom" >
          <template v-slot:activator="{ props }">
            <v-icon v-bind="props" :icon="mdiHelpCircleOutline" size="small" />
          </template>
          <div>{{ subtitle }}</div>
        </v-tooltip>
      </div>
    </v-card-title>

    <v-card-subtitle v-if="subtitle" class="d-none d-sm-block mb-8 mx-7 mx-sm-11 mx-md-15 text-caption" style="white-space: pre-wrap; border-bottom: 1px solid #00695C;">
      {{ subtitle }}
    </v-card-subtitle>

    <div class="mt-5 px-3 px-md-10 py-0">
      <slot />
    </div>

  </v-sheet>
</template>