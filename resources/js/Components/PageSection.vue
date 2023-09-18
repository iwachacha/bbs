<script setup>
  defineProps(['icon', 'title'])
</script>

<template>
  <section>
    <v-card flat class="my-5 mx-sm-10" rounded="lg" color="secondary">
    
      <template v-slot:title>
        <div class="mt-3 ms-1 text-h5 text-medium-emphasis d-flex align-center">
          <v-icon :icon="icon" class="me-2" />
          <h3>{{ title }}</h3>
        </div>
      </template>
    
      <v-container class="px-7 pb-10 mt-2 py-0">
        <slot />
      </v-container>
    
    </v-card>
  </section>
</template>