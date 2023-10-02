<script setup>
	import { ref, watch, computed } from 'vue'
  import { mdiAccount, mdiEmailOutline, mdiEyeOff, mdiEye, mdiLockOutline, mdiChevronRight } from '@mdi/js'
	import { Head, Link, useForm } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import { useVuelidate } from '@vuelidate/core'
  import { required, email, sameAs, maxLength, minLength, helpers } from '@vuelidate/validators'
  import { requiredM, maxLengthM, minLengthM } from '@/validationMessage.js'
  import { getFacultyName, getDepartmentName, getCourseName } from '@/Components/Lectures/GetNameFromId.vue'
  import MustInput from '@/Components/MustInput.vue'
	import PageSection from '@/Components/PageSection.vue'
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

	const form = useForm({
		name: null,
		email: null,
		password: null,
		password_confirmation: null,
		grade: null,
		faculty_id: null,
		department_id: null,
		course_id: null,
		terms: false,
	})

	const registerRules = {
    name: {
      required: helpers.withMessage(requiredM("ユーザー名"), required),
      maxLengthValue: helpers.withMessage(maxLengthM("ユーザー名", 50), maxLength(50))
    },
    password: {
      required: helpers.withMessage(requiredM("パスワード"), required),
			minLengthValue: helpers.withMessage(minLengthM("パスワード", 8), minLength(8)),
			maxLengthValue: helpers.withMessage(maxLengthM("パスワード", 16), maxLength(16))
    },
    password_confirmation: {
      required: helpers.withMessage(requiredM("確認用パスワード"), required),
			minLengthValue: helpers.withMessage(minLengthM("パスワード", 8), minLength(8)),
			maxLengthValue: helpers.withMessage(maxLengthM("パスワード", 16), maxLength(16)),
			sameAs: helpers.withMessage('パスワードが一致していません', sameAs(computed(()=> form.password))),
    },
    email: {
      required: helpers.withMessage(requiredM("大学メールアドレス"), required),
			email: helpers.withMessage('正しい形式で入力してください', email),
    }
  }
  const registerV$ = useVuelidate(registerRules, form)

	const toast = useToast()
	const visiblePassword = ref(false)
	const visibleConfirmPassword = ref(false)

  const sortDepartments = ref()
  const sortCourses = ref()
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
		form.post(route('register'), {
			onSuccess: () => {
				useToast().success('ユーザー登録が完了しました。\nご登録ありがとうございます！')
			},
      onError: () => [useToast().error('入力内容に誤りがあります！\n内容の確認をお願いします。')]
		})
	}

	const showError = () => {
    registerV$.value.$touch()
    useToast().error('入力内容に誤りがあります！\n内容の確認をお願いします。')
  }

	const dialog = ref(false)
  const createUser = ref([])
  const openDialog = () => {
    let selectFacultyName = getFacultyName(props.faculties, form.faculty_id)
    let selectDepartmentName = getDepartmentName(props.departments, form.department_id)
    let selectCourseName = getCourseName(props.courses, form.course_id)

    createUser.value = [
      {key: 'ユーザー名', value: form.name},
      {key: '学年', value: form.grade ? form.grade : '未設定'},
      {key: '所属学部', value: selectFacultyName ? selectFacultyName : '未設定'},
      {key: '所属学科・課程', value: selectDepartmentName ? selectDepartmentName : '未設定'},
      {key: '所属コース・専修', value: selectCourseName ? selectCourseName : '未設定'},
			{key: 'パスワード', value: form.password},
			{key: '大学メールアドレス', value: form.email},
    ]
    dialog.value = true
  }
</script>

<template>
  <Head title="ユーザー登録" />

	<v-app style="background-color: #F5F5F5;">
		<PageSection title="ユーザー登録" :icon="mdiAccount" style="max-width: 1000px;">
			<form @submit.prevent="registerV$.$invalid ? showError() : submit()" id="registerForm">

				<v-row>

					<v-col cols="12" md="6">
						<MustInput
							v-model="form.name"
							variant="outlined"
							hint="ログインに使用します / 重複できません"
							counter="50"
							:error-messages="props.errors.name ? props.errors.name : registerV$.name.$errors.map(e => e.$message)"
							@input="registerV$.name.$touch"
							@blur="registerV$.name.$touch"
							name="username"
              autocomplete="username"
						>ユーザー名</MustInput>
					</v-col>

					<v-col cols="12" sm="6">
						<Select
							v-model="form.grade"
							variant="outlined"
							label="学年"
							:items="['1年', '2年', '3年', '4年', 'その他']"
						/>
					</v-col>

					<v-col cols="12" sm="6" md="4">
						<Select
							v-model="form.faculty_id"
							variant="outlined"
							label="学部"
							:items="props.faculties"
							item-title="name"
            	item-value="id"
						/>
					</v-col>

					<v-col cols="12" sm="6" md="4">
						<Select
							v-model="form.department_id"
							variant="outlined"
							label="学科・課程"
							:items="sortDepartments"
							item-title="name"
            	item-value="id"
							hint="学部選択時のみ選択できます"
						/>
					</v-col>

					<v-col cols="12" sm="6" md="4">
						<Select
							v-model="form.course_id"
							variant="outlined"
							label="コース・専修"
							:items="sortCourses"
							item-title="name"
            	item-value="id"
							hint="学科選択時のみ選択できます"
						/>
					</v-col>

					<v-col cols="12" md="6">
						<MustInput
							v-model="form.password"
							:type="visiblePassword ? 'text' : 'password'"
							variant="outlined"
							hint="ログインに使用します"
							counter="16"
							:prepend-inner-icon="mdiLockOutline"
							:append-inner-icon="visiblePassword ? mdiEye : mdiEyeOff"
							:error-messages="props.errors.password ? props.errors.password : registerV$.password.$errors.map(e => e.$message)"
							@input="registerV$.password.$touch"
							@blur="registerV$.password.$touch"
							@click:append-inner="visiblePassword = !visiblePassword"
						>パスワード</MustInput>
					</v-col>

					<v-col cols="12" md="6">
						<MustInput
							v-model="form.password_confirmation"
							:type="visibleConfirmPassword ? 'text' : 'password'"
							variant="outlined"
							hint="同じパスワードを入力してください"
							counter="16"
							:prepend-inner-icon="mdiLockOutline"
							:append-inner-icon="visibleConfirmPassword ? mdiEye : mdiEyeOff"
							:error-messages="props.errors.password_confirmation ? props.errors.password_confirmation : registerV$.password_confirmation.$errors.map(e => e.$message)"
							@input="registerV$.password_confirmation.$touch"
							@blur="registerV$.password_confirmation.$touch"
							@click:append-inner="visibleConfirmPassword = !visibleConfirmPassword"
						>確認用パスワード</MustInput>
					</v-col>

					<v-col cols="12">
						<MustInput
							v-model="form.email"
							type="email"
							variant="outlined"
							hint="ユーザー情報には含まれません"
							:prepend-inner-icon="mdiEmailOutline"
							:error-messages="props.errors.email ? props.errors.email : registerV$.email.$errors.map(e => e.$message)"
							@input="registerV$.email.$touch"
							@blur="registerV$.email.$touch"
							name="email"
							autocomplete="email"
						>大学メールアドレス</MustInput>
					</v-col>

					<v-col cols="12">
						<v-card
							class="mb-10"
							color="surface-variant"
							variant="tonal"
						>
							<v-card-text class="text-medium-emphasis text-caption">
								メールアドレスは保存されません。<br>文教大学・越谷キャンパスの学生か判断するためにのみ使用されます。
							</v-card-text>
						</v-card>
					</v-col>

				</v-row>
			</form>

			<PrimaryBtn
				block
				class="mb-2"
				@click="registerV$.$invalid ? showError() : openDialog()"
				:disabled="form.processing"
			>
				確認する

				<ConfirmCard
					:dialog="dialog"
					title="ユーザー登録"
					subtitle="送信してもよろしいですか？"
					text="ユーザー名とパスワードはログインに使用しますので、大切に保管してください。"
					:items="createUser"
				>
					<template v-slot:cancelBtn>
						<SecondaryBtn @click="dialog = false">いいえ</SecondaryBtn>
					</template>
					<template v-slot:okBtn>
						<PrimaryBtn type="submit" @click="dialog = false" form="registerForm">はい</PrimaryBtn>
					</template>
				</ConfirmCard>

			</PrimaryBtn>

			<Link :href="route('login')">
				<v-card-text class="text-center" style="color: #26A69A;">
					ログインはこちら<v-icon :icon="mdiChevronRight" />
				</v-card-text>
			</Link>
		</PageSection>
	</v-app>
</template>
