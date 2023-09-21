<script setup>
  import { mdiPenPlus } from '@mdi/js'
  import ReviewForm from '@/Components/Reviews/ReviewForm.vue'
  import PageSection from '@/Components/PageSection.vue'

  const props = defineProps({
    lecture: Object,
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
    :title="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + 'のレビュー作成'"
    :icon="mdiPenPlus"
  >
    <div class="mx-sm-7">
      <ReviewForm
        :lecture="lecture"
        :errors="errors"
        style="background-color: #F5F5F5;"
      />
    </div>
  </PageSection>
</template>
