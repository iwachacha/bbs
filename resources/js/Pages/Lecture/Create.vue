<script setup>
  import { ref } from 'vue'
  import searchLecture from '@/Components/Lectures/SearchLecture.vue'
  import LectureForm from '@/Components/Lectures/LectureForm.vue'
  import ReviewForm from '@/Components/Reviews/ReviewForm.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'

  const props = defineProps({
    lectures: Object,
    faculties: Object,
    departments: Object,
    courses: Object,
    lectureCategories: Object,
    errors: Object
  })

  const step = ref(1)

  const lectureSubmitted = false
  const reviewSubmitted = false
</script>

<script>
  import Layout from '@/Layouts/Layout.vue';
  export default {
    layout: Layout,
  }
</script>

<template>
  <v-stepper
    v-model="step"
    alt-labels
    hide-actions
    class="p-0"
    style="box-shadow: none !important;"
    :items="['講義検索', '講義作成', 'レビュー作成']"
  >

    <template v-slot:item.1>
      <searchLecture
        :lectures="props.lectures"
        :courses="courses"
      />
    </template>

    <template v-slot:item.2>
      <LectureForm
        :errors="props.errors"
        :lecture-categories="props.lectureCategories"
        :faculties="props.faculties"
        :departments="props.departments"
        :courses="props.courses"
        @submitNotice="lectureSubmitted = true"
      />
    </template>

    <template v-slot:item.3>
      <ReviewForm
        :errors="props.errors"
        @submitNotice="reviewSubmitted = true"
      />
    </template>

  </v-stepper>

  <v-divider />

  <v-card-actions class="mb-10">
    <PrimaryBtn
      variant="outlined"
      v-if="step > 1"
      @click="step--"
      :disabled="step == 3 && !reviewSubmitted"
    >
      戻る
    </PrimaryBtn>
    <v-spacer />
    <PrimaryBtn
      variant="outlined"
      v-if="step < 3"
      @click="step++"
      :disabled="step == 2 && !lectureSubmitted"
    >
      次へ
    </PrimaryBtn>
  </v-card-actions>
</template>