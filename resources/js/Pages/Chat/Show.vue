<script setup>
  import { ref } from 'vue'
  import { Head, useForm } from '@inertiajs/vue3'
  import { mdiChatProcessingOutline, mdiReply, mdiSend, mdiPencilOutline, mdiClose } from '@mdi/js'
  import { useToast } from "vue-toastification"
  import PageSection from '@/Components/PageSection.vue'

  const props = defineProps({
    thread: Object,
    errors: Object,
  })

  const resForm = useForm({
    body: null,
    reply_id: null,
  })

  const onSubmit = () => {
    resForm.post(route('chat.res.store', props.thread.id), {
      preserveScroll: true,
      onSuccess: () => [
        useToast().success('投稿が完了しました。'),
        resForm.reset(),
      ],
      onError: () => [useToast().error('入力内容に誤りがあります！\n内容の確認をお願いします。')]
    })
  }
</script>

<script>
  import Layout from '@/Layouts/Layout.vue'
  export default {
    layout: Layout,
  }
</script>

<template>
  <Head :title="'雑談部屋 - ' + props.thread.title" />

  <PageSection
    title="雑談部屋"
    :subtitle="props.thread.title"
    :icon="mdiChatProcessingOutline "
    :guest-viewing="true"
  >
    <v-row justify="center">
      <template v-for="(res, index) in props.thread.responses">
        <v-col cols="12" sm="11" md="9" class="pa-0" style="background-color: white;">
          <v-card-text class="pb-2">
            <div class="text-medium-emphasis d-flex justify-space-between" style="font-size: 0.6rem;">
              <div>
                {{ index+1 + '. ' }}
                <span v-if="res.user">{{ res.user.name }}さん</span>
                <span v-else>ゲストさん</span>
                <span>{{ '（' + res.created_at + '）' }}</span>
              </div>

              <v-icon
                :icon="(resForm.reply_id === index+1 ) ? mdiClose : mdiReply" size="large"
                @click="(resForm.reply_id === index+1) ? resForm.reply_id = null : resForm.reply_id = index+1"
              />
            </div>

            <div v-if="res.reply_id" class="text-body-2 mt-1 ms-1 font-weight-medium">
              <div class="text-caption text-medium-emphasis">
                {{ '>> ' + res.reply_id }}
              </div>
              <div class="ms-2">{{ res.body }}</div>
            </div>

            <div v-else class="text-body-2 mt-1 ms-1 font-weight-medium">
              {{ res.body }}
            </div>
          </v-card-text>
          <v-divider class="border-opacity-100" />
        </v-col>
      </template>

      <v-col cols="11" sm="9" md="7" class="pa-0" style="position: fixed; bottom: 0;">
        <v-textarea
          v-model="resForm.body"
          :label="(resForm.reply_id) ? resForm.reply_id + 'への返信内容（500文字まで）' : '投稿内容（500文字まで）'"
          placeholder="過激な発言はお控えください"
          :prepend-inner-icon="mdiPencilOutline"
          variant="solo"
          hide-details="auto"
          auto-grow
          no-resize
          rows="2"
          class="mb-2"
          :error-messages="props.errors.body || props.errors.reply_id"
        >
          <template v-slot:append-inner>
            <v-icon
              :icon="mdiSend"
              color="primary"
              @click="onSubmit()"
            />
          </template>
        </v-textarea>
      </v-col>
    </v-row>
  </PageSection>
</template>

<style>
  .v-field__append-inner {
    align-items: flex-end !important;
    padding-bottom: 10px;
  }
</style>