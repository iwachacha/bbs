<script setup>
  import { watch, ref } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { mdiMagnify } from '@mdi/js'
  import { useToast } from "vue-toastification"
  import SearchInput from '@/Components/SearchInput.vue'

  const props = defineProps({
    resultCount: Number,
    query: Object
  })

    const search_word = ref(props.query['search_word'])

  watch(search_word, () => {
    if(search_word.value.length <= 4){
      router.get(route('review.index', [props.query, { search_word: search_word.value, page: null }]), {}, {
        onSuccess: () => {
          useToast().success(props.resultCount + '件取得しました。')
        },
        preserveState: true,
        preserveScroll: true,
        only: ['reviews', 'resultCount', 'query'],
      })
    }
    else if(search_word.value.length > 5) {
      search_word.value.pop()
    }
  })
</script>

<template>
  <SearchInput
    v-model="search_word"
    :icon="mdiMagnify"
    placeholder="検索ワードを入力してください"
    label="キーワード検索(4つまで)"
    hide-no-data
    :disabled="!$page.props.auth.user"
  />
</template>