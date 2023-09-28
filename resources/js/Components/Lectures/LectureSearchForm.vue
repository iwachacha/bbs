<script setup>
  import { watch, ref, reactive } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { mdiMagnify } from '@mdi/js'
  import { useToast } from "vue-toastification"
  import SearchInput from '@/Components/SearchInput.vue'
  import LinkBtn from '@/Components/LinkBtn.vue'

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
    router.get(route('lecture.index', [props.query, form]), {}, {
      onSuccess: () => {
        useToast().success(props.resultCount + '件取得しました。')
      },
      preserveState: true,
      preserveScroll: true,
      only: ['lectures', 'resultCount', 'query'],
    })
  })

  //検索用に講義名と教員名を重複なしで配列に摘出
  const lectureNames = props.names.map((name) => name.lecture_name)
  const professorNames = props.names.map((name) => name.professor_name)
  const names = Array.from(new Set(lectureNames.concat(professorNames)))

  const inputName = ref(null) //検索ボックスで項目選択前の入力された値
</script>

<template>
  <v-row justify="end" class="me-1">
    <v-col cols="auto" class="pt-0">
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
    label="講義名・教員名検索"
  />

  <div class="text-right mt-n1 mt-sm-n3">
    <LinkBtn :href="route('lecture.index')" variant="text">
      検索条件リセット
    </LinkBtn>
  </div>
</template>