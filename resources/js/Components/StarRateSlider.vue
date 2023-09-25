<script setup>
  defineProps(['text'])
</script>

<template>
  <v-range-slider
    min="1"
    max="5"
    color="primary"
    step="0.1"
    density="compact"
    hide-details
  >
  </v-range-slider>
</template>