<script setup>
  import { useForm } from '@inertiajs/vue3'
  import { ref } from 'vue'
  import { useToast } from "vue-toastification"
  import { useVuelidate } from '@vuelidate/core'
  import { required, helpers } from '@vuelidate/validators'
  import { requiredM } from '@/validationMessage.js'
  import MustInput from '@/Components/MustInput.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
	import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'

  const toast = useToast()
  const passwordInput = ref(null)
  const visible = ref(false)
  const dialog = ref(false)

  const form = useForm({
    password: null,
    delete_confirm: null
  })

  const deleteUserRules = {
    password: {
      required: helpers.withMessage(requiredM("パスワード"), required),
    },
    delete_confirm: {
      required: helpers.withMessage(requiredM("削除確認"), required),
    }
  }
  const deleteUserV$ = useVuelidate(deleteUserRules, form)

  const deleteUser = () => {
    form.delete(route('profile.destroy'), {
      preserveScroll: true,
      onError: () => [toast.error('パスワードに誤りがあります。')],
    })
  }

  const showError = () => {
    deleteUserV$.value.$touch()
    toast.error('入力内容に誤りがあります！\n内容の確認をお願いします。')
  }
</script>

<template>
  <form @submit.prevent="deleteUserV$.$invalid ? showError() : deleteUser()" id="deleteUserForm">
    <v-row>
      <v-col cols="12" class="pb-0">
        <MustInput
          ref="passwordInput"
          v-model="form.password"
          :type="visible ? 'text' : 'password'"
          variant="outlined"
          counter="16"
          :append-inner-icon="visible ? mdiEye : mdiEyeOff"
          :error-messages="(form.errors.password) ? form.errors.password : deleteUserV$.password.$errors.map(e => e.$message)"
          @input="deleteUserV$.password.$touch"
          @blur="deleteUserV$.password.$touch"
          @click:append-inner="visible = !visible"
        >現在のパスワード</MustInput>
      </v-col>

      <v-col cols="12" class="pb-0">
        <MustInput
          v-model="form.delete_confirm"
          variant="outlined"
          placeholder="アカウント削除"
          hint="「アカウント削除」と入力してください"
          :error-messages="(form.errors.delete_confirm) ? form.errors.delete_confirm : deleteUserV$.delete_confirm.$errors.map(e => e.$message)"
          @input="deleteUserV$.delete_confirm.$touch"
          @blur="deleteUserV$.delete_confirm.$touch"
        >削除確認</MustInput>
      </v-col>
    </v-row>
  </form>

  <PrimaryBtn
    block
    class="mb-5 mt-8"
    @click="deleteUserV$.$invalid ? showError() : dialog = true"
    :disabled="form.processing"
    color="#D50000"
  >
    アカウントを削除する

    <ConfirmCard
      :dialog="dialog"
      title="アカウント削除"
      subtitle="本当に削除してもよろしいですか？"
      text="削除した情報は復元できません。"
    >
      <template v-slot:cancelBtn>
        <SecondaryBtn @click="dialog = false">いいえ</SecondaryBtn>
      </template>
      <template v-slot:okBtn>
        <PrimaryBtn color="#D50000" type="submit" @click="dialog = false" form="deleteUserForm">はい</PrimaryBtn>
      </template>
    </ConfirmCard>

  </PrimaryBtn>

</template>
