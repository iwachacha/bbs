<script setup>
  import { ref } from 'vue'
  import { useForm, router } from '@inertiajs/vue3'
  import { mdiThumbUpOutline, mdiThumbDownOutline } from '@mdi/js'
  import { useToast } from "vue-toastification"
  import { useVuelidate } from '@vuelidate/core'
  import { required, maxLength, helpers } from '@vuelidate/validators'
  import { requiredM, maxLengthM } from '@/validationMessage.js'
  import MustInput from '@/Components/MustInput.vue'
  import MustSelect from '@/Components/MustSelect.vue'
  import TextArea from '@/Components/TextArea.vue'
  import StarRate from '@/Components/StarRate.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'

  const props = defineProps({
    errors: Object,
    lecture: {
      type: Object,
      default: null
    },
    reviews: {
      type: Object,
      default: null
    },
  })

  const emit = defineEmits(['isSubmit']);
  const submitNotice = () => {
    emit('isSubmit')
  }

  let now = new Date()
  let nowYear = now.getFullYear()
  let dateOptions = []
  for(let i = nowYear; i+10 >= nowYear; i--){
    dateOptions.push(i + '年')
  }

  const toast = useToast()

  const reviewForm = useForm({
    title: props.reviews ? props.reviews.title : null,
    year: props.reviews ? props.reviews.year : null,
    fulfillment_rate: props.reviews ? props.reviews.fulfillment_rate : null,
    ease_rate: props.reviews ? props.reviews.ease_rate : null,
    satisfaction_rate: props.reviews ? props.reviews.title : null,
    lecture_content: props.reviews ? props.reviews.lecture_content : null,
    good_point: props.reviews ? props.reviews.good_point : null,
    bad_point: props.reviews ? props.reviews.bad_point : null,
  })

  const reviewRules = {
    title: {
      required: helpers.withMessage(requiredM("タイトル"), required),
      maxLengthValue: helpers.withMessage(maxLengthM("タイトル", 50), maxLength(50))
    },
    year: {
      required: helpers.withMessage(requiredM("受講年度"), required),
      maxLengthValue: helpers.withMessage(maxLengthM("受講年度", 50), maxLength(50))
    },
    fulfillment_rate: {
      required: helpers.withMessage(requiredM("充実度評価"), required),
    },
    ease_rate: {
      required: helpers.withMessage(requiredM("楽単度評価"), required),
    },
    satisfaction_rate: {
      required: helpers.withMessage(requiredM("満足度評価"), required),
    },
    lecture_content: {
      maxLengthValue: helpers.withMessage(maxLengthM("講義内容", 500), maxLength(500))
    },
    good_point: {
      maxLengthValue: helpers.withMessage(maxLengthM("良い点", 500), maxLength(500))
    },
    bad_point: {
      maxLengthValue: helpers.withMessage(maxLengthM("悪い点", 500), maxLength(500))
    }
  }
  const reviewV$ = useVuelidate(reviewRules, reviewForm)

  const onSubmit = () => {
    reviewForm.post('/reviews', {
      onSuccess: () => [
        toast.success('レビュー作成が完了しました！\n投稿ありがとうございます！\n数秒後に講義一覧画面へ遷移します。'),
        reviewForm.reset(),
        reviewV$.value.$reset(),
        submitNotice()
      ],
      onError: () => [toast.error('入力内容に誤りがあります！\n内容の確認をお願いします。')]
    })
  }

  const showError = () => {
    reviewV$.value.$touch()
    toast.error('入力内容に誤りがあります！\n内容の確認をお願いします。')
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
      {key: '講義内容', value: reviewForm.lecture_content ? reviewForm.lecture_content : 'なし'},
      {key: '良い点', value: reviewForm.good_point ? reviewForm.good_point : 'なし'},
      {key: '悪い点', value: reviewForm.bad_point ? reviewForm.bad_point : 'なし'}
    ]
    dialog.value = true
  }

  if(reviewForm.wasSuccessful){
    window.setTimeout(() => {
      router.get(route('lectures.index'))
    }, 7000)
  }
</script>

<template>
  <v-sheet class="py-10 px-5 rounded-lg" style="background-color: #FAFAFA;">
    <v-form @submit.prevent="reviewV$.$invalid ? showError() : onSubmit()" id="reviewForm">

      <v-row>

        <v-col cols="12" sm="6">
          <MustInput
            v-model="reviewForm.title"
            counter="50"
            placeholder="タイトルを入力してください"
            hint="例：一言評価"
            :error-messages="props.errors.title ? props.errors.title : reviewV$.title.$errors.map(e => e.$message)"
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
            :error-messages="props.errors.year ? props.errors.year : reviewV$.year.$errors.map(e => e.$message)"
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
            講義充実度<span  style="color: red">*</span>　☆ {{ reviewForm.fulfillment_rate }}
          </v-list-subheader>
          <v-label>低</v-label>
          <StarRate v-model="reviewForm.fulfillment_rate" />
          <v-label>高</v-label>
          <v-input
            readonly
            class="text-center mb-2"
            :error-messages="props.errors.fulfillment_rate ? props.errors.fulfillment_rate : reviewV$.fulfillment_rate.$errors.map(e => e.$message)"
            @input="reviewV$.fulfillment_rate.$touch"
            @blur="reviewV$.fulfillment_rate.$touch"
          />
          <v-divider :thickness="1" class="border-opacity-100"></v-divider>
          <v-spacer />
        </v-col>

        <v-col cols="auto">
          <v-spacer />
          <v-list-subheader>
            楽単度<span  style="color: red">*</span>　☆ {{ reviewForm.ease_rate }}
          </v-list-subheader>
          <v-label>低</v-label>
          <StarRate v-model="reviewForm.ease_rate" />
          <v-label>高</v-label>
          <v-input
            readonly
            class="text-center mb-3"
            :error-messages="props.errors.ease_rate ? props.errors.ease_rate : reviewV$.ease_rate.$errors.map(e => e.$message)"
            @input="reviewV$.ease_rate.$touch"
            @blur="reviewV$.ease_rate.$touch"
          />
          <v-divider :thickness="1" class="border-opacity-100"></v-divider>
          <v-spacer />
        </v-col>

        <v-col cols="auto">
          <v-spacer />
          <v-list-subheader>
            履修満足度<span  style="color: red">*</span>　☆ {{ reviewForm.satisfaction_rate }}
          </v-list-subheader>
          <v-label>低</v-label>
          <StarRate v-model="reviewForm.satisfaction_rate" />
          <v-label>高</v-label>
          <v-input
            readonly
            class="text-center mb-3"
            :error-messages="props.errors.satisfaction_rate ? props.errors.satisfaction_rate : reviewV$.satisfaction_rate.$errors.map(e => e.$message)"
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
            :error-messages="props.errors.lecture_content ? props.errors.lecture_content : reviewV$.lecture_content.$errors.map(e => e.$message)"
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
            :error-messages="props.errors.good_point ? props.errors.good_point : reviewV$.good_point.$errors.map(e => e.$message)"
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
            :error-messages="props.errors.bad_point ? props.errors.bad_point : reviewV$.bad_point.$errors.map(e => e.$message)"
            @input="reviewV$.bad_point.$touch"
          />
        </v-col>

      </v-row>

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