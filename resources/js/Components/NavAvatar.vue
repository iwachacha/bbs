<script setup>
  defineProps({ name: String})
</script>

<template>
  <v-sheet
    color="grey-lighten-4"
    class="pa-4 d-flex align-center"
  >
    <v-avatar color="grey-darken-1" />
    <div class="ms-4">{{ name }}</div>
  </v-sheet>
</template>