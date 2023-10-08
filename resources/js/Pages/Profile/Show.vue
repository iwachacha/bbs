<script setup>
  import { mdiAccountCircle } from '@mdi/js'
  import Layout from '@/Layouts/Layout.vue'

  const props = defineProps({
    user: Object
  })
</script>

<template>
  <Layout>
    <v-row justify="center" class="mt-8">
      <v-col cols="12" class="pa-0 text-center">
        <v-icon
          :icon="mdiAccountCircle"
          color="#BDBDBD"
          size="100"
        />
        <div class="text-medium-emphasis">{{ user.name }}</div>
      </v-col>
    </v-row>
  </Layout>
</template>
