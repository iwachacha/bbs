<script setup>
  import { mdiAccount, mdiLockOutline, mdiAlertCircle } from '@mdi/js'
  import Layout from '@/Layouts/Layout.vue'
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

<template>
  <Layout>
    <PageSection title="プロフィール編集" :icon="mdiAccount" style="max-width: 800px;">
      <UpdateProfileInformationForm
        :faculties="faculties"
        :departments="departments"
        :courses="courses"
      />
    </PageSection>

    <v-divider class="border-opacity-100" />

    <PageSection title="パスワード変更" :icon="mdiLockOutline"  style="max-width: 800px;">
      <UpdatePasswordForm />
    </PageSection>

    <v-divider class="border-opacity-100" />

    <PageSection
      title="アカウント削除"
      :icon="mdiAlertCircle"
      style="max-width: 800px;">
      <DeleteUserForm />
    </PageSection>
  </Layout>
</template>
