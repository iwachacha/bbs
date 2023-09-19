<script setup>
  import { Head } from '@inertiajs/vue3'
  import { mdiAccount, mdiLockOutline, mdiAlertCircle } from '@mdi/js'
  import DeleteUserForm from './Partials/DeleteUserForm.vue'
  import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'
  import UpdateUserInformationForm from './Partials/UpdateUserInformationForm.vue'
  import PageSection from '@/Components/PageSection.vue'


const props = defineProps({
  status: String,
  faculties: Object,
	departments: Object,
	courses: Object,
})
</script>

<script>
  import Layout from '@/Layouts/Layout.vue'
  export default {
    layout: Layout,
  }
</script>

<template>
  <Head title="アカウント情報" />

  <PageSection title="プロフィール編集" :icon="mdiAccount">
    <UpdateUserInformationForm
      :faculties="props.faculties"
      :departments="props.departments"
      :courses="props.courses"
    />
  </PageSection>

  <PageSection title="パスワード変更" :icon="mdiLockOutline">
    <UpdatePasswordForm />
  </PageSection>

  <PageSection title="アカウント削除" :icon="mdiAlertCircle">
    <DeleteUserForm />
  </PageSection>
</template>
