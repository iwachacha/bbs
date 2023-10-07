<script setup>
  import { mdiChatQuestion } from '@mdi/js'
	import { useForm } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import Layout from '@/Layouts/Layout.vue'
  import PageSection from '@/Components/PageSection.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
	import Select from '@/Components/Select.vue'
	import TextArea from '@/Components/TextArea.vue'
	import Input from '@/Components/Input.vue'

	const form = useForm({
    category: null,
		title: null,
    body: null,
  })

	const submit = () => {
		form.post(route('contact.store'), {
			onSuccess: () => [
        useToast().success('お問い合わせ・ご意見ありがとうございます！\n')
      ]
		})
	}
</script>

<template>
  <Layout>
    <PageSection
      title="お問い合わせ"
      :icon="mdiChatQuestion"
      subtitle="些細なことでもお気軽にお問い合わせください。"
      :guest-viewing="true"
      style="max-width: 800px;"
    >
      <v-form @submit.prevent="submit" id="contactForm">
        <v-row class="mt-0">
          <v-col cols="12" sm="6" class="py-0">
            <Select
              v-model="form.category"
              variant="outlined"
              label="カテゴリー"
              :items="['質問', '意見', '希望', 'バグ報告', 'その他']"
            />
          </v-col>

          <v-col cols="12" sm="6" class="py-0">
            <Input
              v-model="form.title"
              variant="outlined"
              counter="100"
              label="タイトル"
            />
          </v-col>

          <v-col cols="12" class="py-0">
            <TextArea
              v-model="form.body"
              variant="outlined"
              counter="500"
              label="本文"
            />
          </v-col>

          <v-col cols="12" class="py-0">
            <v-card
              class="mb-10"
              color="surface-variant"
              variant="tonal"
            >
              <v-card-text class="text-medium-emphasis text-caption">
                より良い情報共有の場とするため、鋭いご指摘やご意見、機能のご希望など何でもお待ちしております！
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>

        <PrimaryBtn
          type="submit"
          block
          :disabled="form.processing"
          class="mb-2"
        >
          送信する
        </PrimaryBtn>
      </v-form>
    </PageSection>
  </Layout>
</template>
