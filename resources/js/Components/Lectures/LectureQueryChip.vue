<script setup>
  import { computed } from 'vue'
  import { mdiMagnify, mdiReload } from '@mdi/js'
  import { router } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import { getCategoryName, getFacultyName, getDepartmentName } from '@/Components/Lectures/GetNameFromId.vue'
  import LinkBtn from '@/Components/LinkBtn.vue'

  const props = defineProps({
    query:Object,
    lectureCategories: Object,
    faculties: Object,
    departments: Object,
  })

  const chipText = computed(() => (key, value) => {
    switch(key) {
      case 'search_name': return '名前 : ' + value
      case 'lecture_name': return '講義名 : ' + value
      case 'professor_name': return '教員名 : ' + value
      case 'exact': return '完全一致検索'
      case 'sort': return value
      case 'category': return '講義区分 : ' + getCategoryName(props.lectureCategories, value)
      case 'faculty': return '学部 : ' + getFacultyName(props.faculties, value)
      case 'department': return '学科・課程 : ' + getDepartmentName(props.departments, value)
      case 'season': return '開講時期 : ' + value
      case 'fulfillment': return '平均充実度: ☆' + value[0] + ' ～ ☆' + value[1]
      case 'ease': return '平均楽単度: ☆' + value[0] + ' ～ ☆' + value[1]
      case 'satisfaction': return '平均満足度: ☆' + value[0] + ' ～ ☆' + value[1]
    }
  })

  const deleteQuery = (key) => {
    props.query[key] = null

    router.get(route('lecture.index', [props.query]), {}, {
      preserveScroll: true,
      only: ['lectures', 'resultCount', 'query'],
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
        :href="route('lecture.index')"
        :only="['lectures', 'query']"
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