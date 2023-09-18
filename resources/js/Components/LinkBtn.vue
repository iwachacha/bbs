<script setup>
  import { Link } from '@inertiajs/vue3'

  defineProps(['href', 'method', 'color'])
</script>

<template>
  <Link :href="href" :method="method ? method : 'get'" preserve-scroll preserve-state>
    <v-btn block :color="color ? color : 'primary'" class="px-1">
      <slot />
    </v-btn>
  </Link>
</template>
