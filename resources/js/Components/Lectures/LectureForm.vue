<script setup>
  import { ref, watch } from 'vue'
  import { useForm } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import { useVuelidate } from '@vuelidate/core'
  import { required, maxLength, helpers } from '@vuelidate/validators'
  import { requiredM, maxLengthM } from '@/validationMessage.js'
  import MustInput from '@/Components/MustInput.vue'
  import MustSelect from '@/Components/MustSelect.vue'
  import TooltipSelect from '@/Components/TooltipSelect.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'

  const props = defineProps({
    faculties: Object,
    departments: Object,
    courses: Object,
    lectureCategories: Object,
    errors: Object,
    lectures: {
      type: Object,
      default: null
    }
  })

  const emit = defineEmits(['isSubmit']);
  const submitNotice = () => {
    emit('isSubmit')
  }

  const toast = useToast()

  const lectureForm = useForm({
    lecture_name: props.lectures ? props.lectures.lecture_name : null,
    professor_name: props.lectures ? props.lectures.professor_name : null,
    lecture_category_id: props.lectures ? props.lectures.lecture_category_id : null,
    faculty_id: props.lectures ? props.lectures.faculty_id : null,
    department_id: props.lectures ? props.lectures.department_id : null,
    course_id: props.lectures ? props.lectures.course_id : null,
  })

  const lectureRules = {
    lecture_name: {
      required: helpers.withMessage(requiredM("担当教員名"), required),
      maxLengthValue: helpers.withMessage(maxLengthM("担当教員名", 50), maxLength(50))
    },
    professor_name: {
      required: helpers.withMessage(requiredM("講義名"), required),
      maxLengthValue: helpers.withMessage(maxLengthM("講義名", 50), maxLength(50))
    },
    lecture_category_id: {
      required: helpers.withMessage(requiredM("講義区分"), required),
    }
  }
  const lectureV$ = useVuelidate(lectureRules, lectureForm)

  //階層：カテゴリー>学部>学科>コース、学部・学科・コースはリレーションあり
  //カテゴリーの共通教養が選択された場合は学部・学科・コースの選択をリセット
  //共通教養以外が選択された場合は学部の選択肢を追加

  const sortFaculties = ref([])
  const sortDepartments = ref([])
  const sortCourses = ref([])

  watch(
    () => lectureForm.lecture_category_id,
    (lecture_category_id) => {
      if(lecture_category_id === 1){

        lectureForm.faculty_id = []
        lectureForm.department_id = []
        lectureForm.course_id = []
        sortFaculties.value = []

      } else {
        sortFaculties.value = props.faculties
      }
    }
  )

  //親の項目選択によって子の項目を変更+既に子が選択されていた場合は選択リセット
  watch(
    () => lectureForm.faculty_id,
    (faculty_id) => {
      sortDepartments.value = props.departments.filter((department) => department.faculty_id === faculty_id)
      lectureForm.department_id = []
      lectureForm.course_id = []
    }
  )

  watch(
    () => lectureForm.department_id,
    (department_id) => {
      sortCourses.value = props.courses.filter((course) => course.department_id === department_id)
      lectureForm.course_id = []
    }
  )

  const onSubmit = () => {
    lectureForm.post('/lectures', {
      onSuccess: () => [
        toast.success('講義作成が完了しました！\nレビュー作成にお進みください。'),
        lectureForm.reset(),
        lectureV$.value.$reset(),
        submitNotice()
      ],
      onError: () => [toast.error('入力内容に誤りがあります！\n内容の確認をお願いします。')]
    })
  }

  const showError = () => {
    lectureV$.value.$touch()
    toast.error('入力内容に誤りがあります！\n内容の確認をお願いします。')
  }

  const dialog = ref(false)
  const createLecture = ref([])
  const openDialog = () => {
    let selectCategory = props.lectureCategories.find(e => e.id == lectureForm.lecture_category_id)
    let selectFaculty = props.faculties.find(e => e.id == lectureForm.faculty_id)
    let selectDepartment = props.departments.find(e => e.id == lectureForm.department_id)
    let selectCourse = props.courses.find(e => e.id == lectureForm.course_id)

    createLecture.value = [
      {key: '講義名', value: lectureForm.lecture_name},
      {key: '担当教員名', value: lectureForm.professor_name},
      {key: '担当教員名', value: lectureForm.lecture_name},
      {key: '講義区分', value: selectCategory.name},
      {key: '開講学部', value: selectFaculty ? selectFaculty.name : 'なし'},
      {key: '開講学科', value: selectDepartment ? selectDepartment.name : 'なし'},
      {key: '開講コース', value: selectCourse ? selectCourse.name : 'なし'}
    ]
    dialog.value = true
  }
</script>

<template>
  <v-sheet class="py-10 px-5 rounded-lg" style="background-color: #FAFAFA;">
    <v-form @submit.prevent="lectureV$.$invalid ? showError() : onSubmit()" id="lectureForm">

      <v-row>

        <v-col cols="12" sm="4">
          <MustInput
            v-model="lectureForm.lecture_name"
            counter="50"
            placeholder="正しく入力してください"
            hint="例：○情報A　×情報"
            :error-messages="props.errors.lecture_name ? props.errors.lecture_name : lectureV$.lecture_name.$errors.map(e => e.$message)"
            @input="lectureV$.lecture_name.$touch"
            @blur="lectureV$.lecture_name.$touch"
          >
            講義名
          </MustInput>
        </v-col>

        <v-col cols="12" sm="4">
          <MustInput
            v-model="lectureForm.professor_name"
            counter="50"
            placeholder="フルネームを入力してください"
            hint="例：○田中太郎　×田中"
            :error-messages="props.errors.professor_name ? props.errors.professor_name : lectureV$.professor_name.$errors.map(e => e.$message)"
            @input="lectureV$.professor_name.$touch"
            @blur="lectureV$.professor_name.$touch"
          >
            担当教員名
          </MustInput>
        </v-col>

        <v-col cols="12" sm="4">
          <MustSelect
            v-model="lectureForm.lecture_category_id"
            hint="最も近いものを選択してください"
            :items="lectureCategories"
            item-title="name"
            item-value="id"
            :error-messages="props.errors.lecture_category_id ? props.errors.lecture_category_id : lectureV$.lecture_category_id.$errors.map(e => e.$message)"
            @blur="lectureV$.lecture_category_id.$touch"
          >
            講義区分
          </MustSelect>
        </v-col>

        <v-col cols="12" sm="4">
          <TooltipSelect
            v-model="lectureForm.faculty_id"
            label="開講学部"
            hint="指定がある場合のみ選択してください"
            :items="sortFaculties"
            item-title="name"
            item-value="id"
          >
            <span>
              講義区分を選択した場合のみ選択できます！
              <br>
              共通教養を選択した場合は選択できません！
            </span>
          </TooltipSelect>
        </v-col>

        <v-col cols="12" sm="4">
          <TooltipSelect
            v-model="lectureForm.department_id"
            label="開講学科"
            hint="指定がある場合のみ選択してください"
            :items="sortDepartments"
            item-title="name"
            item-value="id"
          >
            <span>開講学部を選択した場合のみ選択できます！</span>
          </TooltipSelect>
        </v-col>

        <v-col cols="12" sm="4">
          <TooltipSelect
            v-model="lectureForm.course_id"
            label="開講コース"
            hint="指定がある場合のみ選択してください"
            :items="sortCourses"
            item-title="name"
            item-value="id"
          >
            <span>開講学科を選択した場合のみ選択できます！</span>
          </TooltipSelect>
        </v-col>

      </v-row>

      <PrimaryBtn
        block
        @click="lectureV$.$invalid ? showError() : openDialog()"
        :disabled="lectureForm.processing || lectureForm.wasSuccessful"
        class="mt-10"
      >
        確認する
      </PrimaryBtn>

      <ConfirmCard
        :dialog="dialog"
        title="講義作成"
        subtitle="送信してもよろしいですか？"
        text="講義は１度作成すると削除に時間がかかります。"
        :items="createLecture"
      >
        <template v-slot:cancelBtn>
          <SecondaryBtn @click="dialog = false">いいえ</SecondaryBtn>
        </template>
        <template v-slot:okBtn>
          <PrimaryBtn type="submit" @click="dialog = false" form="lectureForm">はい</PrimaryBtn>
        </template>
      </ConfirmCard>

    </v-form>
  </v-sheet>
</template>