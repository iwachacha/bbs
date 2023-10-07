<script setup>
  import { ref } from 'vue'
  import { Head, useForm, Link, router } from '@inertiajs/vue3'
  import { mdiChatProcessingOutline, mdiChatOutline, mdiPlus, mdiTagOutline } from '@mdi/js'
  import { useToast } from "vue-toastification"
  import { useVuelidate } from '@vuelidate/core'
  import { required, maxLength, helpers } from '@vuelidate/validators'
  import { requiredM, maxLengthM } from '@/validationMessage.js'
  import Layout from '@/Layouts/Layout.vue'
  import PageSection from '@/Components/PageSection.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import MustInput from '@/Components/MustInput.vue'
  import MustSelect from '@/Components/MustSelect.vue'
  import PaginationBtn from '@/Components/PaginationBtn.vue'
  import SearchThreadForm from '@/Components/Chats/SearchThreadForm.vue'
  import FilterThreadForm from '@/Components/Chats/FilterThreadForm.vue'
  import SortThreadForm from '@/Components/Chats/SortThreadForm.vue'
  import ThreadQueryChip from '@/Components/Chats/ThreadQueryChip.vue'

  const props = defineProps({
    threads: Object,
    threadCategories: Object,
    errors: Object,
    query: Object,
    totalCount: Number
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
    threadForm.post(route('chat.thread.store'), {
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

  //ページネーション
  const movePage = (targetPage) => {
    router.get(props.threads.links[targetPage].url,
    props.query, {
      preserveState: true,
      only: ['threads', 'query'],
    })
  }
</script>

<template>
  <Head title="雑談部屋一覧" />

  <Layout>
    <PageSection
      title="雑談部屋一覧"
      subtitle="完全匿名で会話をすることができます。学生同士での雑談や相談事にお使いください。"
      :icon="mdiChatProcessingOutline "
      :guest-viewing="true"
    >
      <v-row justify="center" class="ma-0">
        <v-col cols="11" sm="9" md="7" class="pa-0">
          <SearchThreadForm
            :result-count="props.threads.total"
            :query="props.query"
          />
        </v-col>

        <v-col cols="12" sm="10" md="8" class="pa-0">
          <div class="d-flex justify-end mt-7">
            <div class="me-3">
              <FilterThreadForm
                :result-count="props.threads.total"
                :thread-categories="props.threadCategories"
                :query="props.query"
              />
            </div>

            <SortThreadForm
              :query="props.query"
            />
          </div>
        </v-col>

        <v-col cols="12" sm="10" md="8" class="pa-0">
          <ThreadQueryChip
            :query="props.query"
            :thread-categories="props.threadCategories"
            :result-count="props.threads.total"
            :total-count="props.totalCount"
          />
        </v-col>
      </v-row>

      <v-row justify="center" class="mt-2">
        <template v-for="thread in props.threads.data">
          <v-col cols="12" sm="10" md="8" class="pa-0" style="background-color: white;">
            <v-card-text class="pb-2">
              <Link :href="route('chat.show', thread.id)">
                <div class="text-subtitle-1">
                  {{ thread.title }}
                </div>
              </Link>

              <div class="text-caption text-medium-emphasis d-flex justify-space-between align-center">
                <div>
                  <span class="me-2">{{ thread.created_at }}</span>
                  <v-icon :icon="mdiTagOutline" />
                  <span>{{ thread.thread_category.name }}</span>
                </div>

                <div>
                  <span v-if="thread.latest_response" class="me-1">
                    <span class="me-3">最終更新：{{ thread.latest_response.created_at }}</span>
                  </span>

                  <Link :href="route('chat.show', thread.id)">
                    <v-icon :icon="mdiChatOutline" size="large" />
                    {{ thread.responses_count }}
                  </Link>
                </div>
              </div>
            </v-card-text>
            <v-divider class="border-opacity-100" />
          </v-col>
        </template>
      </v-row>

      <v-btn
        class="mt-auto text-white"
        color="primary"
        :icon="mdiPlus"
        size="large"
        style="position: fixed; bottom: 5%; right: 5%; opacity: 0.8;"
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
            placeholder="タイトルを入力してください"
            :error-messages="props.errors.title || threadV$.title.$errors.map(e => e.$message)"
            @input="threadV$.title.$touch"
            @blur="threadV$.title.$touch"
          >
            タイトル
          </MustInput>
        </div>
      </ConfirmCard>

      <template v-if="props.threads.last_page > 1">
        <PaginationBtn
          v-model="props.threads.current_page"
          :length="props.threads.last_page"
          @update:modelValue="movePage(props.threads.current_page)"
        />
        <div class="text-center text-caption mt-1" style="color: #26A69A;">
          {{ props.threads.total }}件中 {{ props.threads.from }}~{{ props.threads.to }}件目表示中
        </div>
      </template>
    </PageSection>
  </Layout>
</template>