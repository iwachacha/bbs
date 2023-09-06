<script setup>
  import { Link } from '@inertiajs/vue3';

  defineProps(['href', 'text', 'icon']);
</script>

<template>
  <Link :href="href">
    <v-list-item
      color="teal-darken-2"
      rounded="xl"
      link
      :active="$page.url === href"
    >
      <template v-slot:prepend>
        <v-icon :icon="icon"></v-icon>
      </template>
      <v-list-item-title v-text="text"></v-list-item-title>
    </v-list-item>
  </Link>
</template>