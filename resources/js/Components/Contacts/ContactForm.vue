<script setup>
	import { mdiChatQuestion } from '@mdi/js'
	import { useForm } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
	import Select from '@/Components/Select.vue'
	import TextArea from '@/Components/TextArea.vue'
	import Input from '@/Components/Input.vue'

	const form = useForm({
    category: null,
		title: null,
    body: null,
  })

	const toast = useToast()

	const submit = () => {
		form.post(route('contact.store'), {
			onSuccess: () => [
        toast.success('お問い合わせ・ご意見ありがとうございます！\nお問い合わせは後日Twitterにて対応します。')
      ]
		})
	}
</script>

<template>
	<v-card rounded="lg" flat max-width="700px" class="my-5 mx-auto pa-5 pa-sm-8" color="grey-lighten-4">

		<v-card-title class="text-medium-emphasis text-h5 mb-5 px-0">
			<v-icon :icon="mdiChatQuestion" />
			お問い合わせ
		</v-card-title>

    <form @submit.prevent="submit" id="contactForm">
      <v-row>

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

    </form>
	</v-card>
</template>