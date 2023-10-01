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
    email: null,
    password: null,
    question: null,
    remember: false,
  })

	const toast = useToast()

	const submit = () => {
		form.post(route('admin.login'), {
			onSuccess: () => [
        toast.success('ログインが完了しました。\nお帰りなさい ' + form.name + 'さん！'),
      ],
      onError: () => [toast.error('こちらは開発者限定のログイン画面です。')]
		})
	}
</script>

<template>

  <Head title="ログイン" />
  <v-app style="background-color: #F5F5F5;">

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <PageSection title="ログイン" :icon="mdiLogin" style="max-width: 700px;">

        <form @submit.prevent="submit" id="loginForm">
          <v-row>

            <v-col cols="6" class="py-2">
              <MustInput
                v-model="form.name"
                variant="outlined"
              >???</MustInput>
            </v-col>

            <v-col cols="6" class="py-2">
              <MustInput
                name="email"
                v-model="form.email"
                variant="outlined"
              >???</MustInput>
            </v-col>

            <v-col cols="6" class="py-2">
              <MustInput
                name="email"
                v-model="form.password"
                variant="outlined"
              >???</MustInput>
            </v-col>

            <v-col cols="6" class="py-2">
              <MustInput
                name="email"
                v-model="form.question"
                variant="outlined"
              >???</MustInput>
            </v-col>

            <v-col cols="12" class="py-2">
              <v-card
                name="email"
                class="mb-10"
                color="surface-variant"
                variant="tonal"
              >
                <v-card-text class="text-medium-emphasis text-caption">
                  こちらは開発者限定のログイン画面です。
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

        <Link :href="route('login')">
          <v-card-text class="text-center" style="color: #26A69A;">
            ユーザーログインはこちら<v-icon :icon="mdiChevronRight" />
          </v-card-text>
        </Link>

    </PageSection>
  </v-app>
</template>
