<script setup>
  import { computed } from 'vue'
  import { mdiMessageText, mdiTrashCan, mdiSquareEditOutline, mdiAlertCircle, mdiListBox } from '@mdi/js'
  import { Link, router } from '@inertiajs/vue3'
  import { getCategoryName, getFacultyName } from '@/Components/Lectures/GetNameFromId.vue'
  import LinkBtn from '@/Components/LinkBtn.vue'
  import PageSection from '@/Components/PageSection.vue'
  import PostCard from '@/Components/PostCard.vue'
  import BookmarkBtn from '@/Components/Lectures/BookmarkBtn.vue'

  const props = defineProps({
    lectures: Object,
    BookmarkedLectureId: Array,
    lectureCategories: Object,
    faculties: Object,
  })

  const isBookmarked = computed(() => (lecture_id) => {
    return props.BookmarkedLectureId.find(e => e.lecture_id == lecture_id)
  })
</script>

<script>
  import Layout from '@/Layouts/Layout.vue';
  export default {
    layout: Layout,
  }
</script>

<template>
  <PageSection :icon="mdiListBox" title="講義一覧">
    <v-row justify="space-around">
      <template v-for="lecture in props.lectures">
        <v-col cols="12" sm="10" md="6" lg="4" class="my-2">

          <PostCard
            :bar-title="lecture.lecture_name"
            :card-title="lecture.professor_name"
          >

            <template v-slot:menuItem>
              <v-list-item link :prepend-icon="mdiSquareEditOutline">
                <v-list-item-title class="align-center">編集リクエスト(未完成)</v-list-item-title>
              </v-list-item>
              <v-divider class="border-opacity-50" />
              <v-list-item link :prepend-icon="mdiTrashCan">
                <v-list-item-title>削除依頼(未完成)</v-list-item-title>
              </v-list-item>
              <v-divider class="border-opacity-50" />
              <v-list-item link :prepend-icon="mdiAlertCircle">
                <v-list-item-title>不適切な投稿として報告(未完成)</v-list-item-title>
              </v-list-item>
            </template>

            <template v-slot:subtitle>
              {{ lecture.season }} / {{ getCategoryName(props.lectureCategories, lecture.lecture_category_id) }}
              {{ lecture.faculty_id && ' / ' + getFacultyName(props.faculties, lecture.faculty_id) }}
            </template>

            <template v-slot:text>
              総合平均評価
              <v-rating
                v-model="lecture.average_rate"
                size="18"
                color="primary"
                density="compact"
                half-increments
                readonly
              />
              ({{ Math.floor(lecture.average_rate * 100) / 100 }})
            </template>

            <template v-slot:action>
              <LinkBtn :href="route('review.create', lecture.id)">
                この講義を評価する
              </LinkBtn>
              <v-spacer />
              <BookmarkBtn
                :is-bookmarked="isBookmarked(lecture.id)"
                :lecture-id="lecture.id"
                :count="lecture.lecture_bookmarks_count"
              />
              <LinkBtn :href="route('review.index', lecture.id)">
                <v-icon :icon="mdiMessageText" size="large"/>
                {{ lecture.reviews_count }}
              </LinkBtn>
            </template>

          </PostCard>

        </v-col>
      </template>
    </v-row>
  </PageSection>
</template>