<script setup>
  import { computed, reactive, watch } from 'vue'
  import { mdiMessageText, mdiMagnify, mdiAlertCircle, mdiListBox, mdiChevronRight } from '@mdi/js'
  import { router } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import LinkBtn from '@/Components/LinkBtn.vue'
  import PageSection from '@/Components/PageSection.vue'
  import PostCard from '@/Components/PostCard.vue'
  import BookmarkBtn from '@/Components/Lectures/BookmarkBtn.vue'
  import LectureSearchForm from '@/Components/Lectures/LectureSearchForm.vue'
  import LectureFilterForm from '@/Components/Lectures/LectureFilterForm.vue'
  import LectureSortForm from '@/Components/Lectures/LectureSortForm.vue'
  import StarRateChip from '@/Components/StarRateChip.vue'
  import QueryChip from '@/Components/Lectures/QueryChip.vue'

  const props = defineProps({
    lectures: Object,
    resultCount: Number,
    names: Object,
    BookmarkedLectureId: Array,
    lectureCategories: Object,
    faculties: Object,
    departments: Object,
    query: Object
  })

  const pageSection = computed(() => {
    if(!Object.keys(props.query).length){
      return {
        icon: mdiListBox,
        title: '講義一覧'
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

  const search = reactive({
    lecture_name: null,
    professor_name: null
  })

  watch(search, () => {
    router.get(route('lecture.index', [props.query, search]), {}, {
      onSuccess: () => {
        useToast().success(props.resultCount + '件取得しました。')
      },
      preserveState: true,
      preserveScroll: true,
      only: ['lectures', 'resultCount', 'query'],
    })
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
          :resultCount="resultCount"
          :query="props.query"
        />
      </v-col>
    </v-row>

    <div class="d-flex justify-end mt-7 me-sm-5 mb-2">
      <div class="me-3">
        <LectureFilterForm
          :result-count="props.resultCount"
          :lecture-categories="props.lectureCategories"
          :faculties="props.faculties"
          :departments="props.departments"
          :query="props.query"
        />
      </div>

      <LectureSortForm
        :query="props.query"
      />
    </div>

    <QueryChip
      :query="props.query"
      :lecture-categories="props.lectureCategories"
      :faculties="props.faculties"
      :departments="props.departments"
    />

    <v-row justify="space-around">
      <template v-for="lecture in props.lectures">
        <v-col cols="12" sm="6" lg="4" class="px-2 px-md-3 my-1 my-sm-2">

          <PostCard>
            <template v-slot:barTitle>
              <div @click="search.lecture_name = lecture.lecture_name" style="cursor: pointer;">
                {{ lecture.lecture_name }}
                <v-icon :icon="mdiChevronRight" size="x-small" class="ms-n1" />
              </div>
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
              <div @click="search.professor_name = lecture.professor_name" style="cursor: pointer;">
                {{ lecture.professor_name + '先生' }}
                <v-icon :icon="mdiChevronRight" size="x-small" class="ms-n1 text-disabled" />
              </div>
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
                {{ Math.floor(lecture.reviews_avg_average_rate * 1000) / 1000 }}
              </div>

              <v-row justify="center" class="mt-1">
                <v-col cols="auto" class="px-2">
                  <StarRateChip
                    label="充実"
                    :star="Math.floor(lecture.reviews_avg_fulfillment_rate * 10) / 10"
                    :small="true"
                  />
                </v-col>

                <v-col cols="auto" class="px-2">
                  <StarRateChip
                    label="楽単"
                    :star="Math.floor(lecture.reviews_avg_ease_rate * 10) / 10"
                    :small="true"
                  />
                </v-col>

                <v-col cols="auto" class="px-2">
                  <StarRateChip
                    label="満足"
                    :star="Math.floor(lecture.reviews_avg_satisfaction_rate * 10) / 10"
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