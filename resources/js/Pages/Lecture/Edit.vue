<script setup>
  import { mdiPenPlus } from '@mdi/js'
  import { Head } from '@inertiajs/vue3'
  import LectureForm from '@/Components/Lectures/LectureForm.vue'
  import PageSection from '@/Components/PageSection.vue'

  const props = defineProps({
    lecture: Object,
    faculties: Object,
    departments: Object,
    courses: Object,
    lectureCategories: Object,
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
  <Head :title="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + ' - 講義編集'" />

  <PageSection
    title="講義編集"
    :subtitle="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + '講義を編集できます。'"
    :icon="mdiPenPlus"
  >
    <div class="mx-3 mx-sm-7">
      <LectureForm
        :lecture="props.lecture"
        :lecture-categories="props.lectureCategories"
        :faculties="props.faculties"
        :departments="props.departments"
        :courses="props.courses"
        :errors="errors"
        style="background-color: #F5F5F5;"
      />
    </div>
  </PageSection>
</template>
