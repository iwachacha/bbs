<script setup>
  import { watch, ref, reactive } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { mdiSort } from '@mdi/js'
  import { useToast } from "vue-toastification"

  const props = defineProps({ query: Object })

  const form = reactive({
    sort: props.query['sort']
  })
  const items = ['新しい順', '古い順', 'レビュー数順', '保存数順', '総合評価値順', '充実評価値順', '楽単評価値順' ]

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
        <v-list-item @click="form.sort = '満足評価値順'">満足評価値順</v-list-item>
      </v-list>
    </v-menu>
  </v-btn>
</template>