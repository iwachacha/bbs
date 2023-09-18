<script setup>
  import { Link } from '@inertiajs/vue3';

  defineProps(['href', 'component', 'title', 'icon']);
</script>

<template>
  <Link :href="href">
    <v-list-item
      color="teal-darken-2"
      rounded="xl"
      link
      :title="title"
      :prepend-icon="icon"
      :active="$page.component === component"
    />
  </Link>
</template>