<script setup>
  import { ref, computed } from 'vue'
  import { Head } from '@inertiajs/vue3'
  import { mdiPenPlus } from '@mdi/js'
  import Layout from '@/Layouts/Layout.vue'
  import PageSection from '@/Components/PageSection.vue'
  import MoveReviewPageForm from '@/Components/Lectures/MoveReviewPageForm.vue'
  import LectureForm from '@/Components/Lectures/LectureForm.vue'
  import ReviewForm from '@/Components/Reviews/ReviewForm.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'

  const props = defineProps({
    lectures: Object,
    faculties: Object,
    departments: Object,
    courses: Object,
    lectureCategories: Object,
    tags: Object,
    errors: Object
  })

  const step = ref(1)

  const currentSection = computed(() => {
    switch (step.value) {
      case 1: return {
        title: 'レビュー作成 / 講義検索',
        subtitle: 'レビュー対象の講義が作成済みの場合は検索結果をクリックし、ページを移動してください。'
      }

      case 2: return {
        title: 'レビュー作成 / 講義作成',
        subtitle: 'レビューの対象となる講義を作成してください。' }

      case 3: return {
        title: 'レビュー作成 / 評価作成',
        subtitle: '講義のレビューを作成してください。' }
    }
  })
</script>

<template>
  <Head title="レビュー作成" />

  <Layout>
    <PageSection :title="currentSection.title" :subtitle="currentSection.subtitle" :icon="mdiPenPlus">
      <v-stepper
        v-model="step"
        alt-labels
        hide-actions
        :items="['講義検索', '講義作成', '評価作成']"
        style="background-color: #FAFAFA;"
      >

        <template v-slot:item.1>
          <MoveReviewPageForm
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
            :tags="tags"
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
  </Layout>
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