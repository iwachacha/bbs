<script setup>
  import { mdiPenPlus } from '@mdi/js'
  import { Head } from '@inertiajs/vue3'
  import ReviewForm from '@/Components/Reviews/ReviewForm.vue'
  import PageSection from '@/Components/PageSection.vue'

  const props = defineProps({
    lecture: Object,
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
  <Head :title="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + ' - レビュー作成'" />

  <PageSection
    :title="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + ' - レビュー作成'"
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
</template>
