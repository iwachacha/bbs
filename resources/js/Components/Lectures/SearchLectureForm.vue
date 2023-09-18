<script setup>
  import { ref, watch } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { getCategoryName, getFacultyName, getDepartmentName, getCourseName } from '@/Components/Lectures/GetNameFromId.vue'
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
  const selectLectureInfo = ref()

  watch(selectLectureId, () => {
    if(selectLectureId.value != null){

      selectLectureInfo.value = props.lectures.find((lecture) => lecture.id === selectLectureId.value)

      let categoryName = getCategoryName(props.lectureCategories, selectLectureInfo.value.lecture_category_id)
      let facultyName = getFacultyName(props.faculties, selectLectureInfo.value.faculty_id)
      let departmentName = getDepartmentName(props.departments, selectLectureInfo.value.department_id)
      let courseName = getCourseName(props.courses, selectLectureInfo.value.course_id)

      selectLectureInfo.value = [
        {key: 'ID', value: selectLectureInfo.value.id},
        {key: '講義名', value: selectLectureInfo.value.lecture_name},
        {key: '担当教員名', value: selectLectureInfo.value.professor_name},
        {key: '講義区分', value: categoryName},
        {key: '開講学部', value: facultyName ? facultyName : '未設定'},
        {key: '開講学科', value: departmentName ? departmentName : '未設定'},
        {key: '開講コース', value: courseName ? courseName : '未設定'},
      ]
      dialog.value = true
    }
  })

  const moveReviewPage = () => {
    router.get(route('review.create', selectLectureId.value))
  }
</script>

<template>
  <v-sheet color="#FAFAFA" class="py-5">

    <v-row justify="center">

      <v-col cols="12" sm="8">
        <SearchInput
          v-model="selectLectureId"
          :items="lectures"
          item-value="id"
          item-title="lecture_name"
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
      :items="selectLectureInfo"
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