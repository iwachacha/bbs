<script setup>
  import { mdiDotsVertical } from '@mdi/js'
</script>

<template>
  <v-btn icon class="mx-0">
    <v-icon :icon="mdiDotsVertical"/>
      <v-menu activator="parent">
        <v-list>
          <slot />
        </v-list>
      </v-menu>
  </v-btn>
</template>