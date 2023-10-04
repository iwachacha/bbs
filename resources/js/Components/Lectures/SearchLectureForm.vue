<script setup>
  import { watch, ref, reactive } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { mdiMagnify } from '@mdi/js'
  import { useToast } from "vue-toastification"
  import SearchInput from '@/Components/SearchInput.vue'

  const props = defineProps({
    names: Object,
    resultCount: Number,
    query: Object
  })

  const form = reactive({
    search_name: props.query['search_name'],
    exact: props.query['exact']
  })

  watch(form, () => {
    if(form.search_name.length <= 4){
      router.get(route('lecture.index', [props.query, form]), {}, {
        onSuccess: () => {
          useToast().success(props.resultCount + '件取得しました。')
        },
        preserveState: true,
        preserveScroll: true,
        only: ['lectures', 'resultCount', 'query'],
      })
    }
    else if(form.search_name.length > 5){
      form.search_word.pop()
    }
  })

  //検索用に講義名と教員名を重複なしで配列に摘出
  const lectureNames = props.names.map((name) => name.lecture_name)
  const professorNames = props.names.map((name) => name.professor_name)
  const names = Array.from(new Set(lectureNames.concat(professorNames)))

  const inputName = ref(null) //検索ボックスで項目選択前の入力された値
</script>

<template>
  <v-row justify="end" class="me-4">
    <v-col cols="auto" class="pa-0 pb-2">
      <v-switch
        v-model="form.exact"
        color="primary"
        density="compact"
        hide-details
        true-value="1"
        :false-value="[]"
        :disabled="!form.search_name"
      >
        <template v-slot:label>
          <span class="text-caption">完全一致検索</span>
        </template>
      </v-switch>
    </v-col>
  </v-row>

  <SearchInput
    v-model="form.search_name"
    v-model:search="inputName"
    :items="(inputName) ? names : []"
    :icon="mdiMagnify"
    placeholder="検索ワードを入力してください"
    label="講義名・教員名検索(4つまで)"
    :disabled="!$page.props.auth.user"
  />
</template>