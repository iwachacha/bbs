<script setup>
  import { ref, watch } from 'vue'
  import { router } from '@inertiajs/vue3'
  import SearchInput from '@/Components/SearchInput.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'

  const props = defineProps({
    lectures: Object,
    faculties: Object,
    departments: Object,
    courses: Object,
    lectureCategories: Object,
  })

  const dialog = ref(false)
  const selectLectureId = ref()
  const selectLecture = ref()

  watch(selectLectureId, () => {
    if(selectLectureId._value != null){
      selectLectureId.value = selectLectureId._value
      selectLecture.value = props.courses.filter((course) => course.id === selectLectureId.value)
      selectLecture.value = [
        {key: 'コース名', value: selectLecture.value[0].name},
        {key: 'ID', value: selectLecture.value[0].id},
      ]
      dialog.value = true
    }
  })

  const moveReviewPage = () => {
    router.get(route('review.create', selectLectureId.value))
  }
</script>

<template>
  <v-sheet class="py-10 px-5 rounded-lg" style="background-color: #FAFAFA;">

    <v-row justify="center">

      <v-col cols="12" sm="8">
        <SearchInput
          v-model="selectLectureId"
          :items="courses"
          item-value="id"
          item-title="name"
          label="講義検索"
          hint="例：対象→情報A　○情・A　×じょ・zyo"
        >
          <span>
            作成済みの講義を検索できます！
            <br><br>
            レビュー対象の講義が見つかった場合は、<br>
            検索結果をクリックしてページの遷移先でレビューを作成してください！
            <br><br>
            レビュー対象の講義が見つからなかった場合は、次のステップにお進みください！
          </span>
        </SearchInput>
      </v-col>

    </v-row>

  </v-sheet>
  <div>
    <ConfirmCard
      :dialog="dialog"
      :items="selectLecture"
      title="講義選択"
      subtitle="レビュー対象はこちらですか？"
      text="はいをクリックすると対象のレビューページに遷移します。"
    >
      <template v-slot:cancelBtn>
        <SecondaryBtn @click="dialog = false">いいえ</SecondaryBtn>
      </template>
      <template v-slot:okBtn>
        <PrimaryBtn @click="moveReviewPage">はい</PrimaryBtn>
      </template>
    </ConfirmCard>
  </div>
</template>