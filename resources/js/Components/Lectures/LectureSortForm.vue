<script setup>
  import { watch, ref } from 'vue'
  import { router, useForm } from '@inertiajs/vue3'
  import { mdiFilterPlus, mdiFilterMinus, mdiSort } from '@mdi/js'
  import StarRateSlider from '@/Components/StarRateSlider.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import Select from '@/Components/Select.vue'

  const props = defineProps({
    lectureCategories: Object,
    faculties: Object,
    departments: Object,
    courses: Object,
  })

  const form = useForm({
    star: null,
  })

  /*watch(form, () => {
    router.get(route('lecture.index'), {
      search_name: form.search_name
    }, {
      preserveState: true,
      only: ['lectures']
    })
  })*/

  const open = ref(false)
</script>

<template>
  <v-btn variant="text" elevation="1" class="text-button text-medium-emphasis px-2" @click="open = !open">
    <v-icon :icon="mdiSort" />
    <span>並び替え</span>

    <v-menu activator="parent">
      <v-list>
        <v-list-item>新しい順</v-list-item>
        <v-divider class="border-opacity-100" />

        <v-list-item>古い順</v-list-item>
        <v-divider class="border-opacity-100" />

        <v-list-item>レビュー数順</v-list-item>
        <v-divider class="border-opacity-100" />

        <v-list-item>総合評価値順</v-list-item>
      </v-list>
    </v-menu>
  </v-btn>
</template>