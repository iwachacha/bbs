<script setup>
	import { ref, computed } from 'vue'
  import { mdiAccount, mdiEmailOutline, mdiEyeOff, mdiEye, mdiLockOutline, mdiChevronRight } from '@mdi/js'
	import { Head, Link, useForm } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import { useVuelidate } from '@vuelidate/core'
  import { required, sameAs, maxLength, minLength, helpers } from '@vuelidate/validators'
  import { requiredM, maxLengthM, minLengthM } from '@/validationMessage.js'
  import MustInput from '@/Components/MustInput.vue'
	import PageSection from '@/Components/PageSection.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
	import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'

	const props = defineProps({
		errors: Object,
	})

	const form = useForm({
		name: null,
		email: null,
		password: null,
		password_confirmation: null,
	})

	const registerRules = {
    name: {
      required: helpers.withMessage(requiredM("ユーザー名"), required),
      maxLengthValue: helpers.withMessage(maxLengthM("ユーザー名", 50), maxLength(50))
    },
    password: {
      required: helpers.withMessage(requiredM("パスワード"), required),
			minLengthValue: helpers.withMessage(minLengthM("パスワード", 8), minLength(8)),
			maxLengthValue: helpers.withMessage(maxLengthM("パスワード", 16), maxLength(16))
    },
    password_confirmation: {
      required: helpers.withMessage(requiredM("確認用パスワード"), required),
			minLengthValue: helpers.withMessage(minLengthM("パスワード", 8), minLength(8)),
			maxLengthValue: helpers.withMessage(maxLengthM("パスワード", 16), maxLength(16)),
			sameAs: helpers.withMessage('パスワードが一致していません', sameAs(computed(()=> form.password))),
    },
    email: {
      required: helpers.withMessage(("必須項目です"), required),
			sameAs: helpers.withMessage('値が正しくありません', sameAs('bunkyo.ac.jp')),
    },
  }
  const registerV$ = useVuelidate(registerRules, form)

	const visiblePassword = ref(false)
	const visibleConfirmPassword = ref(false)

	const submit = () => {
		form.post(route('register'), {
			onSuccess: () => {
				useToast().success('ユーザー登録が完了しました。\nご登録ありがとうございます！')
			},
      onError: () => [useToast().error('入力内容に誤りがあります！\n内容の確認をお願いします。')]
		})
	}

	const showError = () => {
    registerV$.value.$touch()
    useToast().error('入力内容に誤りがあります！\n内容の確認をお願いします。')
  }

	const dialog = ref(false)
  const createUser = ref([])
  const openDialog = () => {
    createUser.value = [
      {key: 'ユーザー名', value: form.name},
			{key: 'パスワード', value: form.password},
    ]
    dialog.value = true
  }
</script>

<template>
  <Head title="ユーザー登録" />

	<v-app style="background-color: #F5F5F5;">
		<PageSection
			title="ユーザー登録"
			:icon="mdiAccount"
			:guest-viewing="true"
			style="max-width: 700px;"
		>
			<form @submit.prevent="registerV$.$invalid ? showError() : submit()" id="registerForm">
				<v-row>
					<v-col cols="12">
						<MustInput
							v-model="form.name"
							variant="outlined"
							hint="ログインに使用します / 重複できません"
							counter="50"
							:error-messages="props.errors.name ? props.errors.name : registerV$.name.$errors.map(e => e.$message)"
							@input="registerV$.name.$touch"
							@blur="registerV$.name.$touch"
							name="username"
              autocomplete="username"
						>ユーザー名</MustInput>
					</v-col>

					<v-col cols="12">
						<MustInput
							v-model="form.password"
							:type="visiblePassword ? 'text' : 'password'"
							variant="outlined"
							hint="ログインに使用します"
							counter="16"
							:prepend-inner-icon="mdiLockOutline"
							:append-inner-icon="(visiblePassword) ? mdiEye : mdiEyeOff"
							:error-messages="props.errors.password || registerV$.password.$errors.map(e => e.$message)"
							@input="registerV$.password.$touch"
							@blur="registerV$.password.$touch"
							@click:append-inner="visiblePassword = !visiblePassword"
						>パスワード</MustInput>
					</v-col>

					<v-col cols="12">
						<MustInput
							v-model="form.password_confirmation"
							:type="visibleConfirmPassword ? 'text' : 'password'"
							variant="outlined"
							hint="同じパスワードを入力してください"
							counter="16"
							:prepend-inner-icon="mdiLockOutline"
							:append-inner-icon="(visibleConfirmPassword) ? mdiEye : mdiEyeOff"
							:error-messages="props.errors.password_confirmation || registerV$.password_confirmation.$errors.map(e => e.$message)"
							@input="registerV$.password_confirmation.$touch"
							@blur="registerV$.password_confirmation.$touch"
							@click:append-inner="visibleConfirmPassword = !visibleConfirmPassword"
						>確認用パスワード</MustInput>
					</v-col>

					<v-col cols="12">
						<MustInput
							v-model="form.email"
							variant="outlined"
							hint="~@gmail.com → gmail.com"
							placeholder="@の後ろを入力してください"
							:prepend-inner-icon="mdiEmailOutline"
							:error-messages="props.errors.email || registerV$.email.$errors.map(e => e.$message)"
							@input="registerV$.email.$touch"
							@blur="registerV$.email.$touch"
						>大学メールアドレス(ドメイン)</MustInput>
					</v-col>

					<v-col cols="12">
						<v-card
							class="mb-10"
							color="surface-variant"
							variant="tonal"
						>
							<v-card-text class="text-medium-emphasis text-caption">
								ユーザー名とパスワードはログインに使用します。
							</v-card-text>
						</v-card>
					</v-col>
				</v-row>
			</form>

			<PrimaryBtn
				block
				class="mb-2"
				@click="registerV$.$invalid ? showError() : openDialog()"
				:disabled="form.processing"
			>
				確認する
				<ConfirmCard
					:dialog="dialog"
					title="ユーザー登録"
					subtitle="送信してもよろしいですか？"
					text="ユーザー名とパスワードはログインに使用しますので、大切に保管してください。"
					:items="createUser"
				>
					<template v-slot:cancelBtn>
						<SecondaryBtn @click="dialog = false">いいえ</SecondaryBtn>
					</template>
					<template v-slot:okBtn>
						<PrimaryBtn type="submit" @click="dialog = false" form="registerForm">はい</PrimaryBtn>
					</template>
				</ConfirmCard>
			</PrimaryBtn>

			<Link :href="route('login')">
				<v-card-text class="text-center" style="color: #26A69A;">
					ログインはこちら<v-icon :icon="mdiChevronRight" />
				</v-card-text>
			</Link>
		</PageSection>
	</v-app>
</template>
