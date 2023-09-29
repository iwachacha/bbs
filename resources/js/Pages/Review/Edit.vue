<script setup>
  import { mdiSquareEditOutline } from '@mdi/js'
  import { Head } from '@inertiajs/vue3'
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
  <Head :title="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + ' - レビュー編集'" />

  <PageSection
    :title="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + ' - レビュー編集'"
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
