<script setup>
  import { mdiSquareEditOutline } from '@mdi/js'
  import ReviewForm from '@/Components/Reviews/ReviewForm.vue'
  import PageSection from '@/Components/PageSection.vue'

  const props = defineProps({
    lecture: Object,
    review: Object,
    tags: Object,
    errors: Object
  })
</script>

<script>
  import Layout from '@/Layouts/Layout.vue'
  export default {
    layout: Layout,
  }
</script>

<template>
  <PageSection
    :title="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + 'のレビュー編集'"
    :icon="mdiSquareEditOutline"
  >
    <div class="mx-3 mx-sm-7">
      <ReviewForm
        :lecture="props.lecture"
        :review="props.review"
        :tags="props.tags"
        :errors="props.errors"
        style="background-color: #F5F5F5;"
      />
    </div>
  </PageSection>
</template>
