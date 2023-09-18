<script setup>
	import { Head, Link } from '@inertiajs/vue3';

	defineProps({ canLogin: Boolean, canRegister: Boolean,});

	const colors = ['indigo', 'warning', 'pink darken-2', 'red lighten-1', 'deep-purple accent-4']
	const slides = ['First', 'Second', 'Third', 'Fourth', 'Fifth']
</script>

<template>
  <Head title="Welcome" />
	<v-app>

		<v-carousel
			cycle
			height="200"
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

	</v-app>

    <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
      <Link
        v-if="$page.props.auth.user"
        :href="route('lecture.create')"
        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
        >ホーム</Link
      >

       <template v-else>
          <Link
            :href="route('login')"
            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
            >ログイン</Link
        	>

          <Link
              v-if="canRegister"
              :href="route('register')"
              class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
              >新規登録</Link
          >
      </template>
  	</div>
</template>

<style>
</style>
