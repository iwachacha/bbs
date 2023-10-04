<script setup>
	import { Head, Link } from '@inertiajs/vue3'
	import { mdiNewBox, mdiAccountOutline } from '@mdi/js'
	import PageSection from '@/Components/PageSection.vue'

	const props = defineProps({
		userCount: Number,
		lectures: Object,
		reviews: Object,
		threads: Object,
	})
</script>

<script>
  import Layout from '@/Layouts/Layout.vue'
  export default {
    layout: Layout,
  }
</script>

<template>
	<Head title="ホーム" />
		<div style="position: relative;">
			<v-img
				:src="'Images/大学風景.jpg'"
				height="350"
				cover
				class="home_img"
			/>

			<div class="text-right mb-3 mt-5 me-3 home_user_count">
				<v-chip color="primary" variant="outlined">
					<v-icon start :icon="mdiAccountOutline" />
					現在のユーザー数 : {{ userCount }}人
				</v-chip>
			</div>

			<div class="home_title">
				<v-card-title class="text-medium-emphasis text-h5 text-md-h4 px-0 text-center">
					文教大学・越谷キャンパス<br class="d-sm-none">情報掲示板
				</v-card-title>

				<v-card-subtitle
					class="text-caption text-sm-subtitle-2 mt-2 px-0 text-center"
					style="white-space: normal;"
				>
					皆さんの学生生活を少しでも豊かにできるよう、日々開発を進めていきます！
				</v-card-subtitle>
			</div>
		</div>

		<PageSection
			title="新着記事"
			subtitle="最新の投稿5件はこちらです。"
			:icon="mdiNewBox "
			:guest-viewing="true"
		>
			<div class="text-center">実装中</div>
		</PageSection>
</template>

<style>
	.home_img {
		filter: blur(5px);
		opacity: 0.4;
	}

	.home_user_count {
		position: absolute;
		top: 5%; right: 2%;
	}

	.home_title {
		position: absolute;
		top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
	}
</style>

