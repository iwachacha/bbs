<script setup>
  import { ref, reactive } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { mdiFilterPlus, mdiFilterMinus, mdiFilterCheck } from '@mdi/js'
  import { useToast } from "vue-toastification"
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import Select from '@/Components/Select.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'

  const props = defineProps({
    resultCount: Number,
    threadCategories: Object,
    query: Object
  })

  const form = reactive({
    category: props.query['category'] && Number(props.query['category']),
  })

  const onSubmit = () => {
    router.get(route('chat.index', [props.query, form]), {}, {
      onSuccess: () => {
        useToast().success('絞り込みの結果' + props.resultCount + '件取得しました。')
      },
      preserveState: true,
      preserveScroll: true,
      only: ['threads', 'resultCount', 'query'],
    })
  }

  const dialog = ref(false)
</script>

<template>
  <v-btn
    variant="text"
    elevation="1"
    class="text-button text-medium-emphasis px-2"
    @click="dialog = true"
  >
    <v-icon :icon="(dialog) ? mdiFilterMinus : mdiFilterPlus" />
    <span>絞り込み</span>
  </v-btn>

  <ConfirmCard
      :dialog="dialog"
      title="絞り込み検索"
    >
      <v-form @submit.prevent="onSubmit()" id="ThreadFilterForm">
        <Select
          v-model="form.category"
          :items="props.threadCategories"
          label="カテゴリー"
          item-title="name"
          item-value="id"
        />
      </v-form>

      <template v-slot:cancelBtn>
        <SecondaryBtn @click="dialog = false">閉じる</SecondaryBtn>
      </template>
      <template v-slot:okBtn>
        <PrimaryBtn type="submit" @click="dialog = false" form="ThreadFilterForm">
          <v-icon :icon="mdiFilterCheck" />
          <span>絞り込む</span>
        </PrimaryBtn>
      </template>
    </ConfirmCard>
</template>