<script setup>
  import { computed, reactive, watch } from 'vue'
  import { Head } from '@inertiajs/vue3'
  import { mdiMessageText, mdiMagnify, mdiAlertCircle, mdiHumanMaleBoard, mdiChevronRight } from '@mdi/js'
  import { router } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import LinkBtn from '@/Components/LinkBtn.vue'
  import PageSection from '@/Components/PageSection.vue'
  import PostCard from '@/Components/PostCard.vue'
  import PaginationBtn from '@/Components/PaginationBtn.vue'
  import BookmarkBtn from '@/Components/Lectures/BookmarkBtn.vue'
  import SearchLectureForm from '@/Components/Lectures/SearchLectureForm.vue'
  import FilterLectureForm from '@/Components/Lectures/FilterLectureForm.vue'
  import SortLectureForm from '@/Components/Lectures/SortLectureForm.vue'
  import StarRateChip from '@/Components/StarRateChip.vue'
  import LectureQueryChip from '@/Components/Lectures/LectureQueryChip.vue'

  const props = defineProps({
    lectures: Object,
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
        icon: mdiHumanMaleBoard,
        title: '講義検索'
      }
    }
    else {
      return {
        icon: mdiMagnify,
        title: '講義検索結果' + '（' + props.lectures.total + '件）'
      }
    }
  })

  //ログイン中のユーザーが各投稿をブックマーク登録済みかどうか
  const isBookmarked = computed(() => (lecture_id) => {
    return props.BookmarkedLectureId.find(e => e.lecture_id == lecture_id)
  })

  //講義名・教員名クリックで検索
  const search = reactive({
    lecture_name: null,
    professor_name: null
  })

  watch(search, () => {
    router.get(route('lecture.index', [props.query, search]), {}, {
      onSuccess: () => {
        useToast().success(props.lectures.total + '件取得しました。')
      },
      preserveState: true,
      preserveScroll: true,
      only: ['lectures', 'query'],
    })
  })

  //ページネーション
  const movePage = (targetPage) => {
    router.get(props.lectures.links[targetPage].url,
    props.query, {
      preserveState: true,
      only: ['lectures', 'query'],
    })
  }
</script>

<script>
  import Layout from '@/Layouts/Layout.vue'
  export default {
    layout: Layout,
  }
</script>

<template>
  <Head :title="pageSection.title" />

  <PageSection :icon="pageSection.icon" :title="pageSection.title">

    <v-row justify="center">
      <v-col cols="11" sm="9" md="7" class="pa-0">
        <SearchLectureForm
          :names="names"
          :result-count="props.lectures.total"
          :query="props.query"
        />
      </v-col>
    </v-row>

    <div class="d-flex justify-end mt-7 me-sm-5">
      <div class="me-3">
        <FilterLectureForm
          :result-count="props.lectures.total"
          :lecture-categories="props.lectureCategories"
          :faculties="props.faculties"
          :departments="props.departments"
          :query="props.query"
        />
      </div>

      <SortLectureForm
        :query="props.query"
      />
    </div>

    <LectureQueryChip
      :query="props.query"
      :lecture-categories="props.lectureCategories"
      :faculties="props.faculties"
      :departments="props.departments"
    />

    <v-row justify="space-around" class="mt-0">
      <template v-for="lecture in props.lectures.data">
        <v-col cols="12" sm="6" lg="4" class="px-2 px-md-3 py-2 py-sm-3">

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
                {{ Math.floor(lecture.average_rate * 1000) / 1000 }}
              </div>

              <v-row justify="center" class="mt-0 mb-0">
                <v-col cols="auto" class="px-2">
                  <StarRateChip
                    label="充実度"
                    :star="Math.floor(lecture.fulfillment_rate_avg * 10) / 10"
                    :small="true"
                  />
                </v-col>

                <v-col cols="auto" class="px-2">
                  <StarRateChip
                    label="楽単度"
                    :star="Math.floor(lecture.ease_rate_avg * 10) / 10"
                    :small="true"
                  />
                </v-col>

                <v-col cols="auto" class="px-2">
                  <StarRateChip
                    label="満足度"
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
              <LinkBtn :href="route('lecture.show', lecture.id)" :block="true" class="ms-1">
                <v-icon :icon="mdiMessageText" size="large"/>
                {{ lecture.reviews_count }}
              </LinkBtn>
            </template>
          </PostCard>
        </v-col>
      </template>
    </v-row>

    <PaginationBtn
      v-model="props.lectures.current_page"
      :length="props.lectures.last_page"
      @update:modelValue="movePage(props.lectures.current_page)"
      v-if="props.lectures.last_page > 1"
    />
  </PageSection>
</template>