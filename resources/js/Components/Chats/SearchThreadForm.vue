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

  const search_title = ref(props.query['search_title'])

  watch(search_title, () => {
    if(search_title.value.length <= 4){
      router.get(route('chat.index', [props.query, { search_title: search_title.value }]), {}, {
        onSuccess: () => {
          useToast().success(props.resultCount + '件取得しました。')
        },
        preserveState: true,
        preserveScroll: true,
        only: ['threads', 'resultCount', 'query'],
      })
    }
    else if(search_title.value.length > 5) {
      search_title.value.pop()
    }
  })
</script>

<template>
  <SearchInput
    v-model="search_title"
    :icon="mdiMagnify"
    placeholder="検索ワードを入力してください"
    label="タイトル検索(4つまで)"
    hide-no-data
  />
</template>