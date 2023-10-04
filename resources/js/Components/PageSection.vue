<script setup>
  defineProps(['icon', 'title', 'subtitle'])
</script>

<template>
  <v-sheet rounded="0" color="secondary" class="mb-16 mx-auto">

    <v-card-title
      class="ps-0 pe-10 mt-7 text-h6 text-sm-h5 text-medium-emphasis d-flex align-center justify-center"
      style="white-space: normal; line-height: normal;"
    >
      <v-icon :icon="icon" class="me-2" size="32" />
      <h2>{{ title }}</h2>
    </v-card-title>

    <v-card-subtitle v-if="subtitle" class="px-0 pb-2 text-center text-caption" style="white-space: pre-wrap;">
      {{ subtitle }}
    </v-card-subtitle>

    <div class="mt-5 px-3 px-md-10 py-0">
      <slot />
    </div>

  </v-sheet>
</template>