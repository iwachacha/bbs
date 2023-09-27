<script setup>
  import { computed } from 'vue'
  import { mdiMessageText, mdiMagnify, mdiAlertCircle, mdiListBox, mdiChevronRight } from '@mdi/js'
  import { Link } from '@inertiajs/vue3'
  import LinkBtn from '@/Components/LinkBtn.vue'
  import PageSection from '@/Components/PageSection.vue'
  import PostCard from '@/Components/PostCard.vue'
  import BookmarkBtn from '@/Components/Lectures/BookmarkBtn.vue'
  import LectureSearchForm from '@/Components/Lectures/LectureSearchForm.vue'
  import LectureFilterForm from '@/Components/Lectures/LectureFilterForm.vue'
  import LectureSortForm from '@/Components/Lectures/LectureSortForm.vue'
  import StarRateChip from '@/Components/StarRateChip.vue'

  const props = defineProps({
    lectures: Object,
    resultCount: Number,
    names: Object,
    BookmarkedLectureId: Array,
    lectureCategories: Object,
    faculties: Object,
  })

  const pageSection = computed(() => {
    const param = new URLSearchParams(window.location.search)

    if(!param.size) {
      return { icon: mdiListBox, title: '講義一覧'}
    }
    else if(param.has('lecture_name')){
      return {
        icon: mdiMagnify,
        title: '講義検索 - ' + param.get('lecture_name') + '（' + props.resultCount + '件）'
      }
    }
    else if(param.has('professor_name')){
      return {
        icon: mdiMagnify,
        title: '講義検索 - ' + param.get('professor_name') + '先生（' + props.resultCount + '件）'
      }
    }
    else {
      return {
        icon: mdiMagnify,
        title: '講義検索' + '（' + props.resultCount + '件）'
      }
    }
  })

  //ログイン中のユーザーが各投稿をブックマーク登録済みかどうか
  const isBookmarked = computed(() => (lecture_id) => {
    return props.BookmarkedLectureId.find(e => e.lecture_id == lecture_id)
  })
</script>

<script>
  import Layout from '@/Layouts/Layout.vue'
  export default {
    layout: Layout,
  }
</script>

<template>
  <PageSection :icon="pageSection.icon" :title="pageSection.title">

    <v-row justify="center">
      <v-col cols="11" sm="9" md="7" class="pa-0">
        <LectureSearchForm
          :names="names"
        />
      </v-col>
    </v-row>

    <div class="d-flex justify-end mt-7 mb-1 me-sm-5">
      <div class="me-2"><LectureFilterForm /></div>
      <LectureSortForm />
    </div>

    <v-row justify="space-around">
      <template v-for="lecture in props.lectures">
        <v-col cols="12" sm="6" lg="4" class="px-2 px-md-3 my-1 my-sm-2 my-md-3">

          <PostCard>
            <template v-slot:barTitle>
              <Link
                :href="route('lecture.index')"
                :data="{ lecture_name: lecture.lecture_name }"
                :only="['lectures', 'resultCount']"
              >
                {{ lecture.lecture_name }}
                <v-icon :icon="mdiChevronRight" size="x-small" class="ms-n1" />
              </Link>
            </template>

            <template v-slot:menuItem>
              <v-list-item link>
                <v-list-item-title>
                  <v-icon :icon="mdiAlertCircle" class="text-medium-emphasis" />
                  不適切な投稿として報告
                </v-list-item-title>
              </v-list-item>
            </template>

            <template v-slot:cardTitle>
              <Link
                :href="route('lecture.index')"
                :data="{ professor_name: lecture.professor_name }"
                :only="['lectures', 'resultCount']"
              >
                {{ lecture.professor_name + '先生' }}
                <v-icon :icon="mdiChevronRight" size="x-small" class="ms-n1 text-disabled" />
              </Link>
            </template>

            <template v-slot:subtitle>
              {{ lecture.season }}
              {{ ' / ' + lecture.lecture_category.name }}
              {{ lecture.faculty && ' / ' + lecture.faculty.name }}
              {{ lecture.department && ' / ' + lecture.department.name }}
              {{ lecture.course && ' / ' + lecture.course.name }}
            </template>

            <template v-slot:text>
              <div class="text-subtitle-2">
                総合平均評価
                <span class="text-body-1" style="color: #26A69A;">★</span>
                {{ Math.floor(lecture.average_rate * 1000) / 1000 }}
              </div>

              <v-row justify="center" class="mt-1">
                <v-col cols="auto" class="px-2">
                  <StarRateChip
                    label="充実"
                    :star="Math.floor(lecture.fulfillment_rate_avg * 10) / 10"
                    :small="true"
                  />
                </v-col>

                <v-col cols="auto" class="px-2">
                  <StarRateChip
                    label="楽単"
                    :star="Math.floor(lecture.ease_rate_avg * 10) / 10"
                    :small="true"
                  />
                </v-col>

                <v-col cols="auto" class="px-2">
                  <StarRateChip
                    label="満足"
                    :star="Math.floor(lecture.satisfaction_rate_avg * 10) / 10"
                    :small="true"
                  />
                </v-col>
              </v-row>
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
              <LinkBtn :href="route('lecture.show', lecture.id)" :block="true">
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