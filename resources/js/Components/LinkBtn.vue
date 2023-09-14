<script setup>
  import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link>
      <div class="pa-2">
        <v-btn block color="teal-lighten-1">
          <slot />
        </v-btn>
      </div>
    </Link>
</template>
