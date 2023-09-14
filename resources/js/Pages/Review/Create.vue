<script setup>
  import ReviewForm from '@/Components/Reviews/ReviewForm.vue'

  const props = defineProps({
    lecture: Object,
    errors: Object
  })
</script>

<script>
  import Layout from '@/Layouts/Layout.vue';
  export default {
    layout: Layout,
  }
</script>

<template>
  <v-sheet class="mx-auto px-5 py-10">
    <ReviewForm
      :lecture="lecture"
      :errors="errors"
    />
  </v-sheet>
</template>
