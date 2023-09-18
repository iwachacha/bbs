<script setup>
  defineProps({ name: String, grade: String, faculty: String})
</script>

<template>
  <v-sheet
    color="grey-lighten-3"
    class="ps-3 d-flex align-center"
    height="64px"
  >
    <v-avatar color="grey-darken-1" />
    <div class="ms-4">
      <div>{{ name }}</div>
      <div class="text-caption text-medium-emphasis">{{ faculty && faculty + ' / ' }}{{ grade && grade}}</div>
    </div>
  </v-sheet>
</template>