<script setup>
  import { mdiMessageText } from '@mdi/js'
  import PageSection from '@/Components/PageSection.vue'

  const props = defineProps({
    lecture: Object,
  })
</script>

<script>
  import Layout from '@/Layouts/Layout.vue';
  export default {
    layout: Layout,
  }
</script>

<template>
  <PageSection :title="props.lecture.lecture_name + '（' + props.lecture.reviews_count + '件）'" :icon="mdiMessageText">
    
  </PageSection>
</template>
