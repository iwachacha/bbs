<script setup>
  import { watch, reactive } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { mdiMagnify } from '@mdi/js'
  import { useToast } from "vue-toastification"
  import SearchInput from '@/Components/SearchInput.vue'

  const props = defineProps({
    resultCount: Number,
    query: Object
  })

  const form = reactive({
    search_word: props.query['search_word']
  })

  watch(form, () => {
    router.get(route('review.index', [props.query, form]), {}, {
      onSuccess: () => {
        useToast().success(props.resultCount + '件取得しました。')
      },
      preserveState: true,
      preserveScroll: true,
      only: ['reviews', 'resultCount', 'query'],
    })
  })

  watch(
    () => form.search_word,
    (search_word) => {
      if(search_word.length > 5) {
        search_word.pop()
      }
    }
  )
</script>

<template>
  <SearchInput
    v-model="form.search_word"
    :icon="mdiMagnify"
    placeholder="検索ワードを入力してください"
    label="キーワード検索(5つまで)"
    hide-no-data
  />
</template>