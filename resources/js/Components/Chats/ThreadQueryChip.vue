<script setup>
  import { computed } from 'vue'
  import { mdiMagnify, mdiReload } from '@mdi/js'
  import { router } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import LinkBtn from '@/Components/LinkBtn.vue'

  const props = defineProps(['query', 'threadCategories', 'totalCount', 'resultCount'])

  const getCategoryName = (targetId) => {
    let targetCategory = props.threadCategories.find(e => e.id == targetId)
    return targetCategory.name
  }

  const chipText = computed(() => (key, value) => {
    switch(key) {
      case 'search_title': return 'タイトル : ' + value
      case 'sort': return value
      case 'category': return 'カテゴリー : ' + getCategoryName(value)
    }
  })

  const deleteQuery = (key) => {
    props.query[key] = null

    router.get(route('chat.index', [props.query]), {}, {
      preserveScroll: true,
      only: ['threads', 'resultCount', 'query'],
      onSuccess: () => {
        useToast().success('一部検索条件を削除しました。')
      }
    })
  }
</script>

<template>
  <template v-if="Object.keys(props.query).length">
    <div class="mt-3 d-flex align-center">
      <v-label class="me-5">
        <v-icon :icon="mdiMagnify" />
        検索条件
        <span class="ms-3 text-caption">
          {{ props.totalCount }}件中{{ props.resultCount }}件取得
        </span>
      </v-label>
    </div>

    <div class="d-flex flex-wrap ms-4">
      <template v-for="(value, key) in props.query">
        <div class="px-1 py-1">
          <v-chip
            label
            closable
            color="primary"
            class="text-caption px-2"
            style="height: 24px;"
            @click:close="deleteQuery(key)"
          >
            {{ chipText(key, value) }}
          </v-chip>
        </div>
      </template>
      <LinkBtn
        :href="route('chat.index')"
        :only="['threads', 'query']"
        variant="text"
      >
        <v-icon :icon="mdiReload" />
        検索条件リセット
      </LinkBtn>
    </div>
    <v-divider class="border-opacity-100" />
  </template>
</template>