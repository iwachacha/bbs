<script setup>
	import { Head, Link } from '@inertiajs/vue3'
	import { mdiAccountOutline } from '@mdi/js'
	import ContactForm from '@/Components/Contacts/ContactForm.vue'

	defineProps({
		userCount: Number,
		canLogin: Boolean,
		canRegister: Boolean,
	})

	const colors = ['indigo', 'warning', 'pink darken-2', 'red lighten-1', 'deep-purple accent-4']
	const slides = ['紹介画像', '紹介画像', '紹介画像', '紹介画像', '紹介画像']
</script>

<template>
	<Head title="ようこそ" />

	<v-app>
		<v-card
			class="px-5 px-sm-10 py-7"
		>
			<div class="text-right mb-5">
				<v-chip color="primary" variant="outlined">
					<v-icon start :icon="mdiAccountOutline" />
					現在のユーザー数 : {{ userCount }}人
				</v-chip>
			</div>

			<v-card-title class="text-medium-emphasis text-h5 text-md-h4 my-3 px-0 text-center">
				文教大学・越谷キャンパス<br class="d-sm-none">情報掲示板
			</v-card-title>

			<v-card-subtitle class="text-caption text-sm-subtitle-2 mb-3 px-0 pb-3 text-center" style="white-space: normal;">
				皆さんの学生生活を少しでも豊かにできるような情報共有の場となるよう、日々開発を進めていきます！
			</v-card-subtitle>

			<v-carousel
				cycle
				height="300"
				hide-delimiter-background
				show-arrows="hover"
			>
				<v-carousel-item
					v-for="(slide, i) in slides"
					:key="i"
				>
					<v-sheet
						:color="colors[i]"
						height="100%"
					>
						<div class="d-flex fill-height justify-center align-center">
							<div class="text-h2">
								{{ slide }} Slide
							</div>
						</div>
					</v-sheet>
				</v-carousel-item>
			</v-carousel>

			<div v-if="canLogin" class="mb-10 mt-7 text-button text-center text-sm-right">
				<Link
					v-if="$page.props.auth.user"
					:href="route('lecture.index')"
				>
					<v-btn color="primary">
					ホーム
					</v-btn>
				</Link>

				<div v-if="!$page.props.auth.user">
					<Link :href="route('login')">
						<v-btn variant="tonal" color="primary" class="me-5">ログイン</v-btn>
					</Link>

					<Link :href="route('register')">
						<v-btn color="primary">新規登録</v-btn>
					</Link>
				</div>
			</div>

			<ContactForm />

		</v-card>
	</v-app>
</template>

