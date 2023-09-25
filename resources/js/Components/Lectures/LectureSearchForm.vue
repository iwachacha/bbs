<script setup>
  import { watch, ref } from 'vue'
  import { router, useForm } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import SearchInput from '@/Components/SearchInput.vue'

  const props = defineProps({
    names: Object,
  })

  const toast = useToast()

  const form = useForm({
    search_name: null,
    exact: 0
  })

  watch(form, () => {
    router.get(route('lecture.index'), {
      search_name: form.search_name,
      exact: form.exact
    }, {
      preserveState: true,
      only: ['lectures'],
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
        false-value="0"
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
    label="講義名・教員名検索"
  />
</template>