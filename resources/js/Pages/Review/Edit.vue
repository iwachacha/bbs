<script setup>
  import { mdiSquareEditOutline } from '@mdi/js'
  import { Head } from '@inertiajs/vue3'
  import Layout from '@/Layouts/Layout.vue'
  import ReviewForm from '@/Components/Reviews/ReviewForm.vue'
  import PageSection from '@/Components/PageSection.vue'

  const props = defineProps({
    lecture: Object,
    review: Object,
    tags: Object,
    errors: Object
  })
</script>

<template>
  <Head :title="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + ' - レビュー編集'" />

  <Layout>
    <PageSection
      title="レビュー編集"
      :subtitle="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + 'のレビューを編集することができます。'"
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
  </Layout>
</template>
