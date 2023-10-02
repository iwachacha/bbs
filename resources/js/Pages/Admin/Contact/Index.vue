<script setup>
  const props = defineProps({
    contacts: Object,
  })
</script>

<script>
  import Layout from '@/Layouts/AdminLayout.vue'
  export default {
    layout: Layout,
  }
</script>

<template>
  <PageSection title="お問い合わせ一覧">
    <v-table>
      <thead>
        <tr>
          <th class="text-left">
            カテゴリー
          </th>
          <th class="text-left">
            タイトル
          </th>
          <th class="text-left">
            本文
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="contact in props.contacts"
         >
          <td>{{ contact.category }}</td>
          <td>{{ contact.title }}</td>
          <td>{{ contact.body }}</td>
        </tr>
      </tbody>
    </v-table>
  </PageSection>
</template>