<script setup>
  import { Link } from '@inertiajs/vue3'

  defineProps(['href', 'method', 'color', 'block'])
</script>

<template>
  <Link :href="href" :method="method ? method : 'get'">
    <v-btn
      :block="block"
      :color="color ? color : 'primary'"
      class="px-1"
    >
      <slot />
    </v-btn>
  </Link>
</template>
