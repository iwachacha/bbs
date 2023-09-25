<script setup>
  import { watch, ref } from 'vue'
  import { router, useForm } from '@inertiajs/vue3'
  import { mdiFilterPlus, mdiFilterMinus, mdiFilterCheck } from '@mdi/js'
  import StarRateSlider from '@/Components/StarRateSlider.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import Select from '@/Components/Select.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'

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

  const dialog = ref(false)
</script>

<template>
  <v-btn
    variant="text"
    elevation="1"
    class="text-button text-medium-emphasis px-2"
    :persistent="false"
    @click="dialog = true"
  >
    <v-icon :icon="(dialog) ? mdiFilterMinus : mdiFilterPlus" />
    <span>絞り込み</span>
  </v-btn>

  <ConfirmCard
      :dialog="dialog"
      title="絞り込み検索"
    >
      <v-form @submit.prevent="onSubmit()" id="lectureFilterForm">
        <v-row>
          <v-col cols="12" md="6" class="py-0">
            <Select
              :items="['aaa', 'aaa']"
              label="講義区分"
            />
          </v-col>

          <v-col cols="12" md="6" class="py-0">
            <Select
              :items="['aaa', 'aaa']"
              label="開講学部"
            />
          </v-col>

          <v-col cols="12" class="pt-0">
            <span class="text-caption">平均充実度 {{ (form.star) && '☆' + form.star[0] + ' ～ ☆' + form.star[1] }}</span>
            <StarRateSlider v-model="form.star" />
          </v-col>

          <v-col cols="12">
            <span class="text-caption">平均楽単度 {{ (form.star) && '☆' + form.star[0] + ' ～ ☆' + form.star[1] }}</span>
            <StarRateSlider />
          </v-col>

          <v-col cols="12">
            <span class="text-caption">平均満足度 {{ (form.star) && '☆' + form.star[0] + ' ～ ☆' + form.star[1] }}</span>
            <StarRateSlider />
          </v-col>
        </v-row>
      </v-form>

      <template v-slot:cancelBtn>
        <SecondaryBtn @click="dialog = false">閉じる</SecondaryBtn>
      </template>
      <template v-slot:okBtn>
        <PrimaryBtn type="submit" @click="dialog = false" form="lectureFilterForm">
          <v-icon :icon="mdiFilterCheck" />
          <span>絞り込む</span>
        </PrimaryBtn>
      </template>
    </ConfirmCard>
</template>