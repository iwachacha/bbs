<script setup>
  import { computed } from 'vue'
  import { mdiMagnify, mdiReload } from '@mdi/js'
  import { router } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import LinkBtn from '@/Components/LinkBtn.vue'

  const props = defineProps({
    query:Object,
  })

  const chipText = computed(() => (key, value) => {
    switch(key) {
      case 'tag': return '＃タグ : ' + value
      case 'search_word': return 'キーワード : ' + value
      case 'sort': return value
      case 'fulfillment': return '充実度評価: ☆' + value[0] + ' ～ ☆' + value[1]
      case 'ease': return '楽単度評価: ☆' + value[0] + ' ～ ☆' + value[1]
      case 'satisfaction': return '満足度評価: ☆' + value[0] + ' ～ ☆' + value[1]
      case 'year': return '受講年度: ' + value[0] + ' 年 ～ ' + value[1] + ' 年'
    }
  })

  const deleteQuery = (key) => {
    props.query[key] = null

    router.get(route('review.index', [props.query]), {}, {
      preserveScroll: true,
      only: ['reviews', 'query'],
      onSuccess: () => {
        useToast().success('一部検索条件を削除しました。')
      }
    })
  }
</script>

<template>
  <template v-if="Object.keys(props.query).length">
    <div class="mt-3 d-flex">
      <v-label class="me-5">
        <v-icon :icon="mdiMagnify" />
        検索条件
      </v-label>

      <LinkBtn
        :href="route('review.index')"
        :only="['reviews', 'query']"
        variant="text"
      >
        <v-icon :icon="mdiReload" />
        検索条件リセット
      </LinkBtn>
    </div>

    <div class="d-flex flex-wrap mb-2 ms-4">
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
    </div>
    <v-divider class="border-opacity-100" />
  </template>
</template>