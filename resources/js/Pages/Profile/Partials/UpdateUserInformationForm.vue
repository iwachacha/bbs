<script setup>
	import { ref, watch } from 'vue'
	import { useForm, usePage } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import { useVuelidate } from '@vuelidate/core'
  import { required, maxLength, helpers } from '@vuelidate/validators'
  import { requiredM, maxLengthM } from '@/validationMessage.js'
  import { getFacultyName, getDepartmentName, getCourseName } from '@/Components/Lectures/GetNameFromId.vue'
  import MustInput from '@/Components/MustInput.vue'
	import TooltipSelect from '@/Components/TooltipSelect.vue'
  import Select from '@/Components/Select.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
	import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'

	const props = defineProps({
		errors: Object,
		faculties: Object,
		departments: Object,
		courses: Object,
	})

  const user = usePage().props.auth.user;

	const form = useForm({
		name: user.name,
		grade: user.grade,
		faculty_id: user.faculty_id,
		department_id: user.department_id,
		course_id: user.course_id,
	})

	const profileRules = {
    name: {
      required: helpers.withMessage(requiredM("ユーザー名"), required),
      maxLengthValue: helpers.withMessage(maxLengthM("ユーザー名", 50), maxLength(50))
    }
  }
  const profileV$ = useVuelidate(profileRules, form)

	const toast = useToast()

  const sortDepartments = ref(props.departments.filter((department) => department.faculty_id === user.faculty_id))
  const sortCourses = ref(props.courses.filter((course) => course.department_id === user.department_id))
  watch(
    () => form.faculty_id,
    (faculty_id) => {
      sortDepartments.value = props.departments.filter((department) => department.faculty_id === faculty_id)
      form.department_id = null
      form.course_id = null
    }
  )

  watch(
    () => form.department_id,
    (department_id) => {
      sortCourses.value = props.courses.filter((course) => course.department_id === department_id)
      form.course_id = null
    }
  )

	const submit = () => {
		form.patch(route('profile.update'), {
			onSuccess: () => [
        toast.success('アカウント情報が修正されました。'),
      ],
      onError: () => [toast.error('入力内容に誤りがあります！\n内容の確認をお願いします。')]
		})
	}

	const showError = () => {
    profileV$.value.$touch()
    toast.error('入力内容に誤りがあります！\n内容の確認をお願いします。')
  }

	const dialog = ref(false)
  const UpdateUser = ref([])
  const openDialog = () => {
    let selectFacultyName = getFacultyName(props.faculties, form.faculty_id)
    let selectDepartmentName = getDepartmentName(props.departments, form.department_id)
    let selectCourseName = getCourseName(props.courses, form.course_id)

    UpdateUser.value = [
      {key: 'ユーザー名', value: form.name},
      {key: '学年', value: form.grade ? form.grade : '未設定'},
      {key: '所属学部', value: selectFacultyName ? selectFacultyName : '未設定'},
      {key: '所属学科・課程', value: selectDepartmentName ? selectDepartmentName : '未設定'},
      {key: '所属コース・専修', value: selectCourseName ? selectCourseName : '未設定'},
    ]
    dialog.value = true
  }
</script>

<template>
	<form @submit.prevent="profileV$.$invalid ? showError() : submit()" id="profileForm">
		<v-row>

		  <v-col cols="12" class="pb-0">
		  	<MustInput
		  		v-model="form.name"
		  		variant="outlined"
		  		counter="50"
		  		@input="profileV$.name.$touch"
		  		@blur="profileV$.name.$touch"
		  	>ユーザー名</MustInput>
		  </v-col>

			<v-col cols="12" sm="6" class="pt-0">
				<Select
					v-model="form.grade"
					variant="outlined"
					label="学年"
					:items="['1年', '2年', '3年', '4年', 'その他']"
				/>
			</v-col>

			<v-col cols="12" sm="6" class="pt-0">
				<Select
					v-model="form.faculty_id"
					variant="outlined"
					label="学部"
					:items="props.faculties"
					item-title="name"
        	item-value="id"
				/>
			</v-col>

			<v-col cols="12" sm="6" class="py-2">
				<TooltipSelect
					v-model="form.department_id"
					variant="outlined"
					label="学科・課程"
					:items="sortDepartments"
					item-title="name"
        	item-value="id"
				>
					<span>学部を選択した場合のみ選択できます！</span>
				</TooltipSelect>
			</v-col>

			<v-col cols="12" sm="6" class="pt-2">
				<TooltipSelect
					v-model="form.course_id"
					variant="outlined"
					label="コース・専修"
					:items="sortCourses"
					item-title="name"
        	item-value="id"
				>
					<span>学科を選択した場合のみ選択できます！</span>
				</TooltipSelect>
			</v-col>

		</v-row>
	</form>

			<PrimaryBtn
				block
				class="mb-2"
				@click="profileV$.$invalid ? showError() : openDialog()"
				:disabled="form.processing"
			>
				確認する

				<ConfirmCard
					:dialog="dialog"
					title="アカウント情報修正"
					subtitle="送信してもよろしいですか？"
					:items="UpdateUser"
				>
					<template v-slot:cancelBtn>
						<SecondaryBtn @click="dialog = false">いいえ</SecondaryBtn>
					</template>
					<template v-slot:okBtn>
						<PrimaryBtn type="submit" @click="dialog = false" form="profileForm">はい</PrimaryBtn>
					</template>
				</ConfirmCard>

			</PrimaryBtn>

</template>
