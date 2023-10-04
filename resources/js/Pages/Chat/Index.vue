<script setup>
  import { ref } from 'vue'
  import { Head, useForm } from '@inertiajs/vue3'
  import { mdiChatProcessingOutline, mdiMagnify, mdiPlus } from '@mdi/js'
  import { useToast } from "vue-toastification"
  import { useVuelidate } from '@vuelidate/core'
  import { required, maxLength, helpers } from '@vuelidate/validators';
  import { requiredM, maxLengthM } from '@/validationMessage.js';
  import PageSection from '@/Components/PageSection.vue'
  import SearchInput from '@/Components/SearchInput.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import MustInput from '@/Components/MustInput.vue'
  import MustSelect from '@/Components/MustSelect.vue'

  const props = defineProps({
    threads: Object,
    threadCategories: Object,
    errors: Object,
  })

  const dialog = ref(false)

  const threadForm = useForm({
    thread_category_id: null,
    title: null,
  })

  const threadRules = {
    thread_category_id: {
      required: helpers.withMessage(requiredM("カテゴリー"), required),
    },
    title: {
      required: helpers.withMessage(requiredM("タイトル"), required),
      maxLengthValue: helpers.withMessage(maxLengthM("タイトル", 100), maxLength(100))
    }
  }
  const threadV$ = useVuelidate(threadRules, threadForm)

  const onSubmit = () => {
    threadForm.post(route('chat.store'), {
      preserveScroll: true,
      onSuccess: () => [
        useToast().success('雑談部屋の作成が完了しました。'),
        dialog.value = false,
        threadForm.reset(),
      ],
      onError: () => [useToast().error('入力内容に誤りがあります！\n内容の確認をお願いします。')]
    })
  }

  const showError = () => {
    threadV$.value.$touch()
    useToast().error('入力内容に誤りがあります！\n内容の確認をお願いします。')
  }
</script>

<script>
  import Layout from '@/Layouts/Layout.vue'
  export default {
    layout: Layout,
  }
</script>

<template>
  <Head title="雑談部屋" />

  <PageSection
    title="雑談部屋"
    subtitle="学生同士での雑談や相談事にお使いください。"
    :icon="mdiChatProcessingOutline "
  >
    <v-row justify="center">
      <v-col cols="11" sm="9" md="7" class="pa-0">
        <SearchInput
          :icon="mdiMagnify"
          label="部屋検索(4つまで)"
        />
      </v-col>
    </v-row>

    <v-row justify="center">
      <template v-for="thread in props.threads">
        <v-col cols="12">
          {{ thread.title }}
        </v-col>
      </template>
    </v-row>

    <v-btn
      class="mt-auto text-white"
      color="primary"
      :icon="mdiPlus"
      size="large"
      style="position: fixed; bottom: 5%; right: 5%; opacity: 0.7;"
      @click="[threadV$.$reset(), dialog = true]"
    />

    <ConfirmCard
      :dialog="dialog"
      title="雑談部屋作成"
    >
      <template v-slot:cancelBtn>
        <SecondaryBtn @click="[dialog = false, threadV$.$reset()]">いいえ</SecondaryBtn>
      </template>
      <template v-slot:okBtn>
        <PrimaryBtn
          @click="threadV$.$invalid ? showError() : onSubmit()"
          :disabled="threadForm.processing"
        >
          作成
        </PrimaryBtn>
      </template>

      <div class="py-3">
        <MustSelect
          v-model="threadForm.thread_category_id"
          :items="props.threadCategories"
          item-title="name"
          item-value="id"
          :error-messages="props.errors.thread_category_id || threadV$.thread_category_id.$errors.map(e => e.$message)"
          @input="threadV$.thread_category_id.$touch"
          @blur="threadV$.thread_category_id.$touch"
        >
          カテゴリー
        </MustSelect>
      </div>
      <div class="py-3">
        <MustInput
          v-model="threadForm.title"
          counter="100"
          placeholder="部屋名を入力してください"
          :error-messages="props.errors.title || threadV$.title.$errors.map(e => e.$message)"
          @input="threadV$.title.$touch"
          @blur="threadV$.title.$touch"
        >
          部屋名
        </MustInput>
      </div>
    </ConfirmCard>
  </PageSection>
</template>