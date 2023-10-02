<script setup>
  import { ref, computed, watch } from 'vue'
  import { useForm, usePage } from '@inertiajs/vue3'
  import { mdiThumbUpOutline, mdiThumbDownOutline, mdiPound } from '@mdi/js'
  import { useToast } from "vue-toastification"
  import { useVuelidate } from '@vuelidate/core'
  import { reviewRules } from '@/Components/Reviews/ReviewFormValidationRules.vue'
  import MustInput from '@/Components/MustInput.vue'
  import MustSelect from '@/Components/MustSelect.vue'
  import TextArea from '@/Components/TextArea.vue'
  import InputStarRate from '@/Components/InputStarRate.vue'
  import SearchInput from '@/Components/SearchInput.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'

  //レビューページから直接投稿 → props.lecture.idあり
  //講義＋レビュー作成ページから投稿 → flashで対象の講義ID(lecture_id)譲渡
  const LectureId = computed(
    () => (props.lecture) ? props.lecture.id : usePage().props.flash.createdLectureId
  )

  const props = defineProps({
    errors: Object,
    lecture: Object,
    review: Object,
    tags: Object
  })

  const tagNames = props.tags.map((tag) => tag.name) //タグ選択の検索候補
  const reviewTags = (props.review) ? props.review.tags.map((tag) => tag.name) : []

  const reviewForm = useForm({
    title: (props.review) ? props.review.title : null,
    year: (props.review) ? props.review.year : null,
    fulfillment_rate: (props.review) ? props.review.fulfillment_rate : null,
    ease_rate: (props.review) ? props.review.ease_rate : null,
    satisfaction_rate: (props.review) ? props.review.satisfaction_rate : null,
    lecture_content: (props.review) ? props.review.lecture_content : null,
    good_point: (props.review) ? props.review.good_point : null,
    bad_point: (props.review) ? props.review.bad_point : null,
    tag: reviewTags
  })
  const reviewV$ = useVuelidate(reviewRules, reviewForm)

  let nowYear = new Date().getFullYear()
  let dateOptions = []
  for(let i = nowYear; i+10 >= nowYear; i--){
    dateOptions.push(i + '年')
  }

  watch(
    () => reviewForm.tag,
    (tag) => {
      if(tag.length > 3) {
        tag.pop()
      }
    }
  )

  const onSubmit = () => {
    if(usePage().component === 'Review/Create' || usePage().component === 'Lecture/Create'){
      reviewForm.post(route('review.store', LectureId.value), {
        onSuccess: () => [
          usePage().props.flash.error
            ? useToast().error(usePage().props.flash.error + '\nレビューページから編集ページへ移動することができます。')
            : useToast().success('レビューの作成が完了しました。\n投稿ありがとうございます！')
        ],
        onError: () => [useToast().error('入力内容に誤りがあります！\n内容の確認をお願いします。')]
      })
    }
    else if(usePage().component === 'Review/Edit'){
      reviewForm.put(route('review.update', [props.review.id]), {
        onSuccess: () => [
          useToast().success('レビューの編集が完了しました。')
        ],
        onError: () => [useToast().error('入力内容に誤りがあります！\n内容の確認をお願いします。')]
      })
    }
  }

  const showError = () => {
    reviewV$.value.$touch()
    useToast().error('入力内容に誤りがあります！\n内容の確認をお願いします。')
  }

  const dialog = ref(false)
  const createReview = ref([])
  const openDialog = () => {
    createReview.value = [
      {key: 'タイトル', value: reviewForm.title},
      {key: '受講年度', value: reviewForm.year},
      {key: '充実度評価', value: '☆ ' + reviewForm.fulfillment_rate},
      {key: '楽単度評価', value: '☆ ' + reviewForm.ease_rate},
      {key: '満足度評価', value: '☆ ' + reviewForm.satisfaction_rate},
      {key: '講義内容', value: (reviewForm.lecture_content) ? reviewForm.lecture_content : 'なし'},
      {key: '良い点', value: (reviewForm.good_point) ? reviewForm.good_point : 'なし'},
      {key: '悪い点', value: (reviewForm.bad_point) ? reviewForm.bad_point : 'なし'},
      {key: '＃タグ', value: (reviewForm.tag.length !== 0) ? reviewForm.tag.join('・') : 'なし'}
    ]
    dialog.value = true
  }
</script>

<template>
  <v-sheet color="#FAFAFA" class="py-5">
    <v-form @submit.prevent="reviewV$.$invalid ? showError() : onSubmit()" id="reviewForm">

      <v-row>
        <v-col cols="12" sm="6">
          <MustInput
            v-model="reviewForm.title"
            counter="50"
            placeholder="タイトルを入力してください"
            hint="例：一言評価"
            :error-messages="props.errors.title || reviewV$.title.$errors.map(e => e.$message)"
            @input="reviewV$.title.$touch"
            @blur="reviewV$.title.$touch"
          >
            タイトル
          </MustInput>
        </v-col>

        <v-col cols="12" sm="6">
          <MustSelect
            v-model="reviewForm.year"
            hint="受講年度を選択してください"
            :items="dateOptions"
            :error-messages="props.errors.year || reviewV$.year.$errors.map(e => e.$message)"
            @input="reviewV$.year.$touch"
            @blur="reviewV$.year.$touch"
          >
            受講年度
          </MustSelect>
        </v-col>
      </v-row>

      <v-row justify="space-around">
        <v-col cols="auto">
          <v-spacer />
          <v-list-subheader>
            講義充実度
            <v-chip class="px-1" color="#FF5252" size="x-small">
              必須
            </v-chip>
            　☆ {{ reviewForm.fulfillment_rate }}
          </v-list-subheader>

          <v-label>低</v-label>
          <InputStarRate v-model="reviewForm.fulfillment_rate" />
          <v-label>高</v-label>

          <v-input
            readonly
            class="text-center mb-2"
            :error-messages="props.errors.fulfillment_rate || reviewV$.fulfillment_rate.$errors.map(e => e.$message)"
            @input="reviewV$.fulfillment_rate.$touch"
            @blur="reviewV$.fulfillment_rate.$touch"
          />
          <v-divider :thickness="1" class="border-opacity-100" />
          <v-spacer />
        </v-col>

        <v-col cols="auto">
          <v-spacer />
          <v-list-subheader>
            楽単度
            <v-chip class="px-1" color="#FF5252" size="x-small">
              必須
            </v-chip>
            　☆ {{ reviewForm.ease_rate }}
          </v-list-subheader>

          <v-label>低</v-label>
          <InputStarRate v-model="reviewForm.ease_rate" />
          <v-label>高</v-label>

          <v-input
            readonly
            class="text-center mb-3"
            :error-messages="props.errors.ease_rate || reviewV$.ease_rate.$errors.map(e => e.$message)"
            @input="reviewV$.ease_rate.$touch"
            @blur="reviewV$.ease_rate.$touch"
          />
          <v-divider :thickness="1" class="border-opacity-100"></v-divider>
          <v-spacer />
        </v-col>

        <v-col cols="auto">
          <v-spacer />
          <v-list-subheader>
            履修満足度
            <v-chip class="px-1" color="#FF5252" size="x-small">
              必須
            </v-chip>
            　☆ {{ reviewForm.satisfaction_rate }}
          </v-list-subheader>

          <v-label>低</v-label>
          <InputStarRate v-model="reviewForm.satisfaction_rate" />
          <v-label>高</v-label>

          <v-input
            readonly
            class="text-center mb-3"
            :error-messages="props.errors.satisfaction_rate || reviewV$.satisfaction_rate.$errors.map(e => e.$message)"
            @input="reviewV$.satisfaction_rate.$touch"
            @blur="reviewV$.satisfaction_rate.$touch"
          />
          <v-divider :thickness="1" class="border-opacity-100"></v-divider>
          <v-spacer />
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" lg="4">
          <TextArea
            v-model="reviewForm.lecture_content"
            label="講義内容"
            hint="印象に残った内容は？"
            counter="500"
            :error-messages="props.errors.lecture_content || reviewV$.lecture_content.$errors.map(e => e.$message)"
            @input="reviewV$.lecture_content.$touch"
          />
        </v-col>

        <v-col cols="12" lg="4">
          <TextArea
            v-model="reviewForm.good_point"
            :prepend-inner-icon="mdiThumbUpOutline"
            label="良い点"
            hint="受講して良かったことは？"
            counter="500"
            :error-messages="props.errors.good_point || reviewV$.good_point.$errors.map(e => e.$message)"
            @input="reviewV$.good_point.$touch"
          />
        </v-col>

        <v-col cols="12" lg="4">
          <TextArea
            v-model="reviewForm.bad_point"
            :prepend-inner-icon="mdiThumbDownOutline"
            label="悪い点"
            hint="受講して後悔したことは？"
            counter="500"
            :error-messages="props.errors.bad_point || reviewV$.bad_point.$errors.map(e => e.$message)"
            @input="reviewV$.bad_point.$touch"
          />
        </v-col>
      </v-row>

      <v-row justify="center" class="mb-5">
        <v-col cols="12" sm="10" md="8">
          <SearchInput
            v-model="reviewForm.tag"
            :items="tagNames"
            label="＃タグ(10文字以下・3つまで)"
            :icon="mdiPound"
            variant="outlined"
            :error-messages="props.errors['tag.0'] || props.errors['tag.1'] || props.errors['tag.2']"
          />
        </v-col>
      </v-row>

      <v-card color="surface-variant" variant="tonal">
				<v-card-text class="text-medium-emphasis text-caption">
					名誉棄損にあたる表現はお控えください。
				</v-card-text>
			</v-card>

      <PrimaryBtn
        block
        @click="reviewV$.$invalid ? showError() : openDialog()"
        :disabled="reviewForm.processing || reviewForm.wasSuccessful"
        class="mt-10"
      >
        確認する
      </PrimaryBtn>

      <ConfirmCard
        :dialog="dialog"
        title="講義レビュー作成"
        subtitle="送信してもよろしいですか？"
        :items="createReview"
      >
        <template v-slot:cancelBtn>
          <SecondaryBtn @click="dialog = false">いいえ</SecondaryBtn>
        </template>
        <template v-slot:okBtn>
          <PrimaryBtn type="submit" @click="dialog = false" form="reviewForm">はい</PrimaryBtn>
        </template>
      </ConfirmCard>

    </v-form>
  </v-sheet>
</template>