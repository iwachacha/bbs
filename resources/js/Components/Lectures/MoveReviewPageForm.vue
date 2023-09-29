<script setup>
  import { ref, watch } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { mdiMagnify } from '@mdi/js'
  import { getCategoryName, getFacultyName, getDepartmentName, getCourseName } from '@/Components/Lectures/GetNameFromId.vue'
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
  const selectLecture = ref()
  const selectLectureInfo = ref()

  watch(selectLecture, () => {
    if(selectLecture.value != null){

      let categoryName = getCategoryName(props.lectureCategories, selectLecture.value.lecture_category_id)
      let facultyName = getFacultyName(props.faculties, selectLecture.value.faculty_id)
      let departmentName = getDepartmentName(props.departments, selectLecture.value.department_id)
      let courseName = getCourseName(props.courses, selectLecture.value.course_id)

      selectLectureInfo.value = [
        {key: 'ID', value: selectLecture.value.id},
        {key: '講義名', value: selectLecture.value.lecture_name},
        {key: '担当教員名', value: selectLecture.value.professor_name},
        {key: '講義区分', value: categoryName},
        {key: '開講学部', value: facultyName ? facultyName : '未設定'},
        {key: '開講学科・課程', value: departmentName ? departmentName : '未設定'},
        {key: '開講コース・専修', value: courseName ? courseName : '未設定'},
      ]
      dialog.value = true
    }
  })

  const moveReviewPage = () => {
    router.get(route('review.create', selectLecture.value.id))
  }
</script>

<template>
  <v-sheet color="#FAFAFA" class="py-5">

    <v-row justify="center">
      <v-col cols="12" sm="8">
        <v-autocomplete
          :items="lectures"
          v-model="selectLecture"
          :item-title="(item) => item.lecture_name + ' / ' + item.professor_name"
          label="レビュー対象講義検索"
          placeholder="講義名を入力してください"
          hint="例：対象→情報A　○情・A　×じょ・zyo"
          density="compact"
          :append-inner-icon="mdiMagnify"
          clearable
          persistent-hint
          variant="solo"
          menu-icon=""
          no-data-text="対象講義は未作成です"
          return-object
        />
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