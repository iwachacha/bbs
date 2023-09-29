<script setup>
  import { watch, ref, reactive } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { mdiSort } from '@mdi/js'
  import { useToast } from "vue-toastification"

  const props = defineProps({ query: Object })

  const form = reactive({
    sort: props.query['sort']
  })
  const items = ['レビュー数(多い順)', '保存数(多い順)', '平均総合評価(高い順)']

  watch(form, () => {
    router.get(route('lecture.index', [props.query, form]), {}, {
      onSuccess: () => {
        useToast().success(form.sort + 'で並べ替えました。')
      },
      preserveState: true,
      preserveScroll: true,
      only: ['lectures', 'query'],
    })
  })

  const open = ref(false)
</script>

<template>
  <v-btn variant="text" elevation="1" class="text-button text-medium-emphasis px-2" @click="open = !open">
    <v-icon :icon="mdiSort" />
    <span>並び替え</span>

    <v-menu activator="parent">
      <v-list>
        <template v-for="item in items">
          <v-list-item @click="form.sort = item">{{ item }}</v-list-item>
          <v-divider class="border-opacity-100" />
        </template>
        <v-list-item @click="form.sort = '平均総合評価(低い順)'">平均総合評価(低い順)</v-list-item>
      </v-list>
    </v-menu>
  </v-btn>
</template>