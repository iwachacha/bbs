<script setup>
  import { mdiPenPlus } from '@mdi/js'
  import { Head } from '@inertiajs/vue3'
  import Layout from '@/Layouts/Layout.vue'
  import ReviewForm from '@/Components/Reviews/ReviewForm.vue'
  import PageSection from '@/Components/PageSection.vue'

  const props = defineProps({
    lecture: Object,
    tags: Object,
    errors: Object
  })
</script>

<template>
  <Head :title="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + ' - レビュー作成'" />

  <Layout>
    <PageSection
      title="レビュー作成"
      :subtitle="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + 'のレビューを作成してください。'"
      :icon="mdiPenPlus"
    >
      <div class="mx-3 mx-sm-7">
        <ReviewForm
          :lecture="lecture"
          :tags="tags"
          :errors="errors"
          style="background-color: #F5F5F5;"
        />
      </div>
    </PageSection>
  </Layout>
</template>
