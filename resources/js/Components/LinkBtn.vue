<script setup>
  import { Link } from '@inertiajs/vue3'

  defineProps(['href', 'method', 'only', 'color', 'block', 'variant'])
</script>

<template>
  <Link :href="href" :method="method ? method : 'get'" :only="only">
    <v-btn
      :block="block"
      :color="(color) ? color : 'primary'"
      :variant="variant && variant"
      class="px-1"
    >
      <slot />
    </v-btn>
  </Link>
</template>
