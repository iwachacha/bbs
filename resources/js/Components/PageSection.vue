<script setup>
  defineProps(['icon', 'title', 'subtitle'])
</script>

<template>
  <v-sheet rounded="0" color="secondary" class="pb-10 mx-auto">

    <v-card-title class="mx-n1 mt-7 mx-sm-3 mx-md-7 text-h6 text-sm-h5 text-medium-emphasis d-flex align-center">
      <v-icon :icon="icon" class="me-2" size="small" />
      <h3>{{ title }}</h3>
    </v-card-title>

    <v-card-subtitle v-if="subtitle" class="d-none d-sm-block mb-8 mx-7 mx-sm-11 mx-md-15 text-caption" style="white-space: pre-wrap; border-bottom: 1px solid #00695C;">
      {{ subtitle }}
    </v-card-subtitle>

    <div class="mt-5 px-3 px-sm-10 px-md-16 py-0">
      <slot />
    </div>

  </v-sheet>
</template>