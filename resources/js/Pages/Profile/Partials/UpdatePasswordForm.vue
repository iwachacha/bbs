<script setup>
	import { ref, computed } from 'vue'
  import { mdiEyeOff, mdiEye, mdiLockOutline } from '@mdi/js'
	import { useForm } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import { useVuelidate } from '@vuelidate/core'
  import { required, sameAs, maxLength, minLength, helpers } from '@vuelidate/validators'
  import { requiredM, maxLengthM, minLengthM } from '@/validationMessage.js'
  import MustInput from '@/Components/MustInput.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
	import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'

	const props = defineProps({
		errors: Object,
	})

  const passwordInput = ref(null)
  const currentPasswordInput = ref(null)

	const form = useForm({
    current_password: null,
    password: null,
    password_confirmation: null,
  })

	const passwordRules = {
    current_password: {
      required: helpers.withMessage(requiredM("現在のパスワード"), required),
			minLengthValue: helpers.withMessage(minLengthM("現在のパスワード", 8), minLength(8)),
			maxLengthValue: helpers.withMessage(maxLengthM("現在のパスワード", 16), maxLength(16))
    },
    password: {
      required: helpers.withMessage(requiredM("変更後のパスワード"), required),
			minLengthValue: helpers.withMessage(minLengthM("変更後のパスワード", 8), minLength(8)),
			maxLengthValue: helpers.withMessage(maxLengthM("変更後のパスワード", 16), maxLength(16))
    },
    password_confirmation: {
      required: helpers.withMessage(requiredM("確認用パスワード"), required),
			sameAs: helpers.withMessage('パスワードが一致していません', sameAs(computed(()=> form.password))),
    },
  }
  const passwordV$ = useVuelidate(passwordRules, form)

	const toast = useToast()
  const visibleCurrentPassword = ref(false)
	const visiblePassword = ref(false)
	const visibleConfirmPassword = ref(false)

  const submit = () => {
    form.put(route('password.update'), {
      preserveScroll: true,
      onSuccess: () => [form.reset(), toast.success('パスワードの変更が完了しました。')],
      onError: () => {
        if (props.errors.password) {
          form.reset('password', 'password_confirmation');
          passwordInput.value.focus()
        }
        if (props.errors.current_password) {
          form.reset('current_password');
          currentPasswordInput.value.focus()
        }
        toast.error('入力内容に誤りがあります！\n内容の確認をお願いします。')
      }
    })
  }

	const showError = () => {
    passwordV$.value.$touch()
    toast.error('入力内容に誤りがあります！\n内容の確認をお願いします。')
  }

	const dialog = ref(false)
  const updatePassword = ref([])
  const openDialog = () => {
    updatePassword.value = [
      {key: '現在のパスワード', value: form.current_password},
      {key: '変更後のパスワード', value: form.password},
    ]
    dialog.value = true
  }
</script>

<template>
	<form @submit.prevent="passwordV$.$invalid ? showError() : submit()" id="passwordForm">
		<v-row>

      <v-col cols="12" class="pb-0">
				<MustInput
          id="current_password"
          ref="currentPasswordInput"
          v-model="form.current_password"
					:type="visibleCurrentPassword ? 'text' : 'password'"
					variant="outlined"
					counter="16"
					:append-inner-icon="visibleCurrentPassword ? mdiEye : mdiEyeOff"
					@input="passwordV$.current_password.$touch"
					@blur="passwordV$.current_password.$touch"
					@click:append-inner="visibleCurrentPassword = !visibleCurrentPassword"
				>現在のパスワード</MustInput>
			</v-col>

			<v-col cols="12" class="py-0">
				<MustInput
          id="password"
          ref="passwordInput"
          v-model="form.password"
					:type="visiblePassword ? 'text' : 'password'"
					variant="outlined"
					counter="16"
					:append-inner-icon="visiblePassword ? mdiEye : mdiEyeOff"
					@input="passwordV$.password.$touch"
					@blur="passwordV$.password.$touch"
					@click:append-inner="visiblePassword = !visiblePassword"
				>変更後のパスワード</MustInput>
			</v-col>

			<v-col cols="12" class="pt-0">
				<MustInput
          id="password_confirmation"
					v-model="form.password_confirmation"
					:type="visibleConfirmPassword ? 'text' : 'password'"
					variant="outlined"
					counter="16"
					:append-inner-icon="visibleConfirmPassword ? mdiEye : mdiEyeOff"
					@input="passwordV$.password_confirmation.$touch"
					@blur="passwordV$.password_confirmation.$touch"
					@click:append-inner="visibleConfirmPassword = !visibleConfirmPassword"
				>確認用パスワード</MustInput>
			</v-col>

		</v-row>
	</form>

	<PrimaryBtn
		block
		class="mb-2"
		@click="passwordV$.$invalid ? showError() : openDialog()"
		:disabled="form.processing"
	>
		確認する

    <ConfirmCard
      :dialog="dialog"
      title="パスワード変更"
      subtitle="送信してもよろしいですか？"
      text="パスワードはログインに使用しますので、大切に保管してください。"
      :items="updatePassword"
    >
      <template v-slot:cancelBtn>
        <SecondaryBtn @click="dialog = false">いいえ</SecondaryBtn>
      </template>
      <template v-slot:okBtn>
        <PrimaryBtn type="submit" @click="dialog = false" form="registerForm">はい</PrimaryBtn>
      </template>
    </ConfirmCard>

	</PrimaryBtn>
</template>
