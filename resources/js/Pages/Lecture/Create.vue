<script setup>
  import { ref, computed } from 'vue'
  import { mdiPenPlus } from '@mdi/js'
  import PageSection from '@/Components/PageSection.vue'
  import searchLectureForm from '@/Components/Lectures/SearchLectureForm.vue'
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

  const currentSection = computed(() => {
    switch (step.value) {
      case 1: return {
        title: '講義検索',
        tipText: '作成済みの講義を検索できます。\n\nレビュー対象の講義が見つかった場合は検索結果をクリックし、\nページの遷移先でレビューを作成してください。\n\n見つからなかった場合は次のステップにお進みください。'
      }

      case 2: return {
        title: '講義作成',
        tipText: 'レビューの対象となる講義を作成してください。\n*マーク付きの項目は回答必須です。' }

      case 3: return {
        title: 'レビュー作成',
        tipText: '講義のレビューを作成してください。\n*マーク付きの項目は回答必須です。' }
    }
  })
</script>

<script>
  import Layout from '@/Layouts/Layout.vue'
  export default {
    layout: Layout,
  }
</script>

<template>
  <PageSection :title="currentSection.title" :tip-text="currentSection.tipText" :icon="mdiPenPlus">
    <v-stepper
      v-model="step"
      alt-labels
      hide-actions
      :items="['講義検索', '講義作成', 'レビュー作成']"
      style="background-color: #FAFAFA;"
    >

      <template v-slot:item.1>
        <searchLectureForm
          :lectures="props.lectures"
          :lecture-categories="props.lectureCategories"
          :faculties="props.faculties"
          :departments="props.departments"
          :courses="props.courses"
        />
      </template>

      <template v-slot:item.2>
        <LectureForm
          :errors="props.errors"
          :lecture-categories="props.lectureCategories"
          :faculties="props.faculties"
          :departments="props.departments"
          :courses="props.courses"
          @isSubmit="step++"
        />
      </template>

      <template v-slot:item.3>
        <ReviewForm
          :errors="props.errors"
        />
      </template>

      <v-divider />

      <v-card-actions class="mb-3 mx-3">
        <PrimaryBtn
          v-if="step == 2"
          @click="step--"
        >
          戻る
        </PrimaryBtn>
        <v-spacer />
        <PrimaryBtn
          v-if="step == 1"
          @click="step++"
        >
          次へ
        </PrimaryBtn>
      </v-card-actions>
    </v-stepper>
  </PageSection>
</template>

<style>
  .v-stepper--alt-labels .v-stepper-item {
    flex-basis: 33%;
  }

  .v-stepper-item {
    padding: 20px 0;
  }

  .v-stepper-item--selected .v-stepper-item__avatar.v-avatar {
    background-color: #26A69A;
  }

  .v-stepper-item__title {
    opacity: 0.8;
  }
</style>