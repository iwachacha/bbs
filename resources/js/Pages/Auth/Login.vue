<script setup>
	import { ref } from 'vue'
  import { mdiAccount, mdiLogin, mdiEyeOff, mdiEye, mdiLockOutline, mdiChevronRight } from '@mdi/js'
	import { Head, Link, useForm } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import PageSection from '@/Components/PageSection.vue'
  import MustInput from '@/Components/MustInput.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'

	const props = defineProps({
    errors: Object,
		canResetPassword: Boolean,
    status: String,
	})

	const form = useForm({
    name: null,
    password: null,
    remember: false,
  })

	const visiblePassword = ref(false)

	const submit = () => {
		form.post(route('login'), {
			onFinish: () => form.reset('password'),
			onSuccess: () => [
      useToast().success('ログインが完了しました。\nお帰りなさい ' + form.name + 'さん！'),
      ],
      onError: () => [useToast().error('ユーザー情報が存在しません')]
		})
	}
</script>

<template>
  <Head title="ログイン" />

  <v-app style="background-color: #F5F5F5;">
    <PageSection title="ログイン" :icon="mdiLogin" style="max-width: 700px;">

        <form @submit.prevent="submit" id="loginForm">
          <v-row>

            <v-col cols="12" class="py-2">
              <MustInput
                v-model="form.name"
                variant="outlined"
                counter="50"
                :prepend-inner-icon="mdiAccount"
                name="username"
                autocomplete="username"
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
                  パスワードリセット機能は実装していません。
                  パスワードを忘れた場合はもう一度ユーザー登録をお願いします。
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

    </PageSection>
  </v-app>
</template>
