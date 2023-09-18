<script setup>
  import { ref } from 'vue'
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
</script>

<script>
  import Layout from '@/Layouts/Layout.vue';
  export default {
    layout: Layout,
  }
</script>

<template>
  <PageSection title="講義・レビュー作成" :icon="mdiPenPlus">
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