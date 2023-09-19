<script setup>
	import { ref } from 'vue'
  import { mdiAccount, mdiLogin, mdiEyeOff, mdiEye, mdiLockOutline, mdiChevronRight } from '@mdi/js'
	import { Head, Link, useForm } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import MustInput from '@/Components/MustInput.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'

	const props = defineProps({
    errors: Object,
		canResetPassword: Boolean,
    status: String,
	})

	const form = useForm({
    name: '',
    password: '',
    remember: false,
  })

	const toast = useToast()
	const visiblePassword = ref(false)

	const submit = () => {
		form.post(route('login'), {
			onFinish: () => form.reset('password'),
			onSuccess: () => [
        toast.success('ログインが完了しました。\nお帰りなさい ' + form.name + 'さん！'),
      ],
      onError: () => [toast.error('ユーザー情報が存在しません')]
		})
	}
</script>

<template>

  <Head title="ログイン" />

  <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
    {{ status }}
  </div>

	<v-card
		color="secondary"
		class="px-5 px-sm-10 py-7"
	>

		<v-card-title class="text-medium-emphasis text-h5 my-5 px-0">
			<v-icon :icon="mdiLogin" class="me-2" />
			<span>ログイン</span>
		</v-card-title>

		<v-sheet class="my-8 mx-md-10" color="secondary">
      <form @submit.prevent="submit" id="loginForm">
        <v-row>

          <v-col cols="12" class="py-2">
            <MustInput
              v-model="form.name"
              variant="outlined"
              counter="50"
              :prepend-inner-icon="mdiAccount"
            >ユーザー名</MustInput>
          </v-col>

          <v-col cols="12" class="py-2">
            <MustInput
              v-model="form.password"
              :type="visiblePassword ? 'text' : 'password'"
              variant="outlined"
              counter="16"
              :prepend-inner-icon="mdiLockOutline"
              :append-inner-icon="visiblePassword ? mdiEye : mdiEyeOff"
              @click:append-inner="visiblePassword = !visiblePassword"
            >パスワード</MustInput>
          </v-col>

          <v-col cols="12" class="py-2">
            <v-card
              class="mb-10"
              color="surface-variant"
              variant="tonal"
            >
              <v-card-text class="text-medium-emphasis text-caption">
                パスワードを忘れた場合は、Twitterかお問い合わせページより「ユーザー名」を合わせてお知らせください。
              </v-card-text>
            </v-card>
          </v-col>

        </v-row>

        <PrimaryBtn
          type="submit"
          block
          class="mb-2"
          :disabled="form.processing"
        >
          ログイン
        </PrimaryBtn>

      </form>

			<Link :href="route('register')">
				<v-card-text class="text-center" style="color: #26A69A;">
					新規登録はこちら<v-icon :icon="mdiChevronRight" />
				</v-card-text>
			</Link>

		</v-sheet>
	</v-card>
</template>
