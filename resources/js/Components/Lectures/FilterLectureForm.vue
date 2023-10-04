<script setup>
  import { ref, reactive } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { mdiFilterPlus, mdiFilterMinus, mdiFilterCheck } from '@mdi/js'
  import { useToast } from "vue-toastification"
  import Slider from '@/Components/Slider.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import Select from '@/Components/Select.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'

  const props = defineProps({
    resultCount: Number,
    lectureCategories: Object,
    faculties: Object,
    departments: Object,
    query: Object
  })

  const form = reactive({
    season: props.query['season'],
    category: props.query['category'] && Number(props.query['category']),
    faculty: props.query['faculty'] && Number(props.query['faculty']),
    department: props.query['department'] && Number(props.query['department']),
    fulfillment: props.query['fulfillment'],
    ease: props.query['ease'],
    satisfaction: props.query['satisfaction'],
  })

  const onSubmit = () => {
    router.get(route('lecture.index', [props.query, form]), {}, {
      onSuccess: () => {
        useToast().success('絞り込みの結果' + props.resultCount + '件取得しました。')
      },
      preserveState: true,
      preserveScroll: true,
      only: ['lectures', 'resultCount', 'query'],
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
    :disabled="!$page.props.auth.user"
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
              v-model="form.season"
              :items="['春学期', '秋学期', '通年', 'その他']"
              label="開講時期"
            />
          </v-col>

          <v-col cols="12" md="6" class="py-0">
            <Select
              v-model="form.category"
              :items="props.lectureCategories"
              item-title="name"
              item-value="id"
              label="講義区分"
            />
          </v-col>

          <v-col cols="12" md="6" class="py-0">
            <Select
              v-model="form.faculty"
              :items="props.faculties"
              item-title="name"
              item-value="id"
              label="開講学部"
            />
          </v-col>

          <v-col cols="12" md="6" class="py-0">
            <Select
              v-model="form.department"
              :items="props.departments"
              item-title="name"
              item-value="id"
              label="開講学科・課程"
            />
          </v-col>

          <v-col cols="12" class="pt-0">
            <span class="text-caption">
              平均充実度 {{ (form.fulfillment) && '☆' + form.fulfillment[0] + ' ～ ☆' + form.fulfillment[1] }}
            </span>
            <Slider
              v-model="form.fulfillment"
              min="1"
              max="5"
              step="0.1"
            />
          </v-col>

          <v-col cols="12">
            <span class="text-caption">
              平均楽単度 {{ (form.ease) && '☆' + form.ease[0] + ' ～ ☆' + form.ease[1] }}
            </span>
            <Slider
              v-model="form.ease"
              min="1"
              max="5"
              step="0.1"
            />
          </v-col>

          <v-col cols="12" class="mb-2">
            <span class="text-caption">
              平均満足度 {{ (form.satisfaction) && '☆' + form.satisfaction[0] + ' ～ ☆' + form.satisfaction[1] }}
            </span>
            <Slider
              v-model="form.satisfaction"
              min="1"
              max="5"
              step="0.1"
            />
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