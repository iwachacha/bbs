<script setup>
  import { mdiChevronLeft, mdiChevronRight  } from '@mdi/js'
</script>

<template>
  <v-carousel
    :cycle="true"
    height="auto"
    hide-delimiters
    show-arrows="hover"
    hide-delimiter-background
    interval="8000"
  >
    <template v-slot:prev="{ props }">
      <v-btn
        icon
        variant="text"
        color="primary"
        @click="props.onClick"
      >
        <v-icon :icon="mdiChevronLeft" />
      </v-btn>
    </template>
    <template v-slot:next="{ props }">
      <v-btn
        icon
        variant="text"
        color="primary"
        @click="props.onClick"
      >
        <v-icon :icon="mdiChevronRight" />
      </v-btn>
    </template>

    <slot />

  </v-carousel>
</template>