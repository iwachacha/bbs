<script setup>
  import DotMenuBtn from '@/Components/DotMenuBtn.vue'
  defineProps(['barTitle', 'cardTitle', 'subtitle'])
</script>

<template>
  <v-card rounded="sm">

    <v-toolbar density="compact" color="teal-lighten-2">
      <v-toolbar-title class="text-subtitle-1">{{ barTitle }}</v-toolbar-title>
      <DotMenuBtn>
          <slot name="menuItem" />
      </DotMenuBtn>
    </v-toolbar>

    <v-card-title class="mt-2 pb-1 text-body-1">{{ cardTitle }}</v-card-title>
    <v-card-subtitle class="ms-3">
      <slot name="subtitle" />
    </v-card-subtitle>

    <v-card-text class="text-center">
      <slot name="text" />
    </v-card-text>

    <v-divider class="border-opacity-100" />

    <v-card-actions class="py-0">
      <slot name="action" />
    </v-card-actions>

  </v-card>
</template>