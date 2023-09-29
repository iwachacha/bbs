<script setup>
  import { ref, reactive } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { mdiFilterPlus, mdiFilterMinus, mdiFilterCheck } from '@mdi/js'
  import { useToast } from "vue-toastification"
  import Slider from '@/Components/Slider.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'

  const props = defineProps({
    resultCount: Number,
    query: Object
  })

  const form = reactive({
    fulfillment: props.query['fulfillment'],
    ease: props.query['ease'],
    satisfaction: props.query['satisfaction'],
    year: props.query['year'],
  })

  const onSubmit = () => {
    router.get(route('review.index', [props.query, form]), {}, {
      onSuccess: () => {
        useToast().success('絞り込みの結果' + props.resultCount + '件取得しました。')
      },
      preserveState: true,
      preserveScroll: true,
      only: ['reviews', 'resultCount', 'query'],
    })
  }

  const dialog = ref(false)

  const nowYear = new Date().getFullYear()
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
      <v-form @submit.prevent="onSubmit()" id="reviewFilterForm">
        <v-row>
          <v-col cols="12" class="pt-0">
            <span class="text-caption">
              充実度評価 {{ (form.fulfillment) && '☆' + form.fulfillment[0] + ' ～ ☆' + form.fulfillment[1] }}
            </span>
            <Slider
              v-model="form.fulfillment"
              min="1"
              max="5"
              step="1"
            />
          </v-col>

          <v-col cols="12">
            <span class="text-caption">
              楽単度評価 {{ (form.ease) && '☆' + form.ease[0] + ' ～ ☆' + form.ease[1] }}
            </span>
            <Slider
              v-model="form.ease"
              min="1"
              max="5"
              step="1"
            />
          </v-col>

          <v-col cols="12" class="mb-2">
            <span class="text-caption">
              満足度評価 {{ (form.satisfaction) && '☆' + form.satisfaction[0] + ' ～ ☆' + form.satisfaction[1] }}
            </span>
            <Slider
              v-model="form.satisfaction"
              min="1"
              max="5"
              step="1"
            />
          </v-col>

          <v-col cols="12" class="mb-2">
            <span class="text-caption">
              受講年度 {{ (form.year) && + form.year[0] + ' 年 ～ ' + form.year[1] + ' 年' }}
            </span>
            <Slider
              v-model="form.year"
              :min="nowYear-10"
              :max="nowYear"
              step="1"
            />
          </v-col>
        </v-row>
      </v-form>

      <template v-slot:cancelBtn>
        <SecondaryBtn @click="dialog = false">閉じる</SecondaryBtn>
      </template>
      <template v-slot:okBtn>
        <PrimaryBtn type="submit" @click="dialog = false" form="reviewFilterForm">
          <v-icon :icon="mdiFilterCheck" />
          <span>絞り込む</span>
        </PrimaryBtn>
      </template>
    </ConfirmCard>
</template>