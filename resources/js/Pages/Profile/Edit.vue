<script setup>
  import { mdiAccount, mdiLockOutline, mdiAlertCircle } from '@mdi/js'
  import DeleteUserForm from './Partials/DeleteUserForm.vue'
  import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'
  import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue'
  import PageSection from '@/Components/PageSection.vue'

  defineProps({
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
  <PageSection title="プロフィール編集" :icon="mdiAccount">
    <UpdateProfileInformationForm
      :faculties="faculties"
      :departments="departments"
      :courses="courses"
    />
  </PageSection>

  <v-divider class="border-opacity-100" />

  <PageSection title="パスワード変更" :icon="mdiLockOutline">
    <UpdatePasswordForm />
  </PageSection>

  <v-divider class="border-opacity-100" />

  <PageSection title="アカウント削除" :icon="mdiAlertCircle">
    <DeleteUserForm />
  </PageSection>
</template>
