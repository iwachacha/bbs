<script setup>
  import { computed, reactive, watch, ref } from 'vue'
  import { Head } from '@inertiajs/vue3'
  import { mdiMessageText, mdiSquareEditOutline, mdiTrashCan, mdiAlertCircle, mdiHumanMaleBoard, mdiChevronRight } from '@mdi/js'
  import { router } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import LinkBtn from '@/Components/LinkBtn.vue'
  import PageSection from '@/Components/PageSection.vue'
  import PostCard from '@/Components/PostCard.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import PaginationBtn from '@/Components/PaginationBtn.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'
  import BookmarkBtn from '@/Components/Lectures/LectureBookmarkBtn.vue'
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
    query: Object,
    totalCount: Number
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

  //講義削除
  const deleteDialog = ref(false)
  const deleteLectureId = ref(null)
  const deleteLectureContent = ref(null)

  const deleteConfirm = (LectureId) => {
    let targetLecture = props.lectures.data.find((lecture) => lecture.id == LectureId)
    deleteLectureContent.value = [
      {key: '講義名', value: targetLecture.lecture_name},
      {key: '担当教員名', value: targetLecture.professor_name},
      {key: '開講時期', value:  targetLecture.season},
      {key: '講義区分', value: targetLecture.lecture_category.name },
      {key: '開講学部', value: (targetLecture.faculty) ? targetLecture.faculty.name : '未設定'},
      {key: '開講学科・課程', value: (targetLecture.department) ? targetLecture.department.name : '未設定'},
      {key: '開講コース・専修', value: (targetLecture.course) ? targetLecture.course.name : '未設定'}
    ]
    deleteDialog.value = true
  }

  const deleteLecture = () => {
    router.delete(route('lecture.delete', deleteLectureId.value), {
      preserveScroll: true,
      onSuccess: (page) => {[
        page.props.flash.error
          ? useToast().error(page.props.flash.error)
          : useToast().success('講義の削除が完了しました。'),
        deleteLectureId.value = null,
        deleteLectureContent.value = null
      ]},
    })
  }

  //レビュー報告
  const reportDialog = ref(false)
  const reportLectureId = ref(null)
  const reportLectureContent = ref(null)

  const reportConfirm = (lectureId) => {
    let targetLecture = props.lectures.data.find((lecture) => lecture.id === lectureId)
    reportLectureContent.value = [
      {key: '講義名', value: targetLecture.lecture_name},
      {key: '担当教員名', value: targetLecture.professor_name},
      {key: '開講時期', value:  targetLecture.season},
      {key: '講義区分', value: targetLecture.lecture_category.name},
      {key: '開講学部', value: (targetLecture.faculty) ? targetLecture.faculty.name : 'なし'},
      {key: '開講学科・課程', value: (targetLecture.department) ? targetLecture.department.name : 'なし'},
      {key: '開講コース・専修', value: (targetLecture.course) ? targetLecture.course.name : 'なし'}
    ]
    reportDialog.value = true
  }

  const report = () => {
    router.post(route('report'), {
      lecture_id: reportLectureId.value
    }, {
      preserveScroll: true,
      onSuccess: () => {
        useToast().success('不適切な投稿として報告されました。')
        reportLectureId.value = null
        reportLectureContent.value = null
      },
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
  <Head title="講義検索" />

  <PageSection
    :icon="mdiHumanMaleBoard"
    title="講義検索"
    subtitle="講義からレビューを探すことができます。"
  >

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
      :result-count="props.lectures.total"
      :total-count="props.totalCount"
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
              <v-list-item
                v-if="lecture.user.id === $page.props.auth.user.id"
                link
                title="編集"
                :prepend-icon="mdiSquareEditOutline"
                style="color: #26A69A;"
                @click="router.get(route('lecture.edit', lecture.id), {} , {
                  preserveScroll: true,
                  onSuccess: (page) => {
                    page.props.flash.error && useToast().error(page.props.flash.error)
                  }
                })"
              />

              <v-list-item
                v-if="lecture.user.id === $page.props.auth.user.id"
                link
                title="削除"
                :prepend-icon="mdiTrashCan"
                style="color: red;"
                @click="[deleteConfirm(lecture.id), deleteLectureId = lecture.id]"
              />

              <v-list-item
                link
                title="不適切な投稿として報告"
                :prepend-icon="mdiAlertCircle"
                @click="[reportConfirm(lecture.id), reportLectureId = lecture.id]"
              />
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
                総合評価
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

    <template v-if="props.lectures.last_page > 1">
      <PaginationBtn
        v-model="props.lectures.current_page"
        :length="props.lectures.last_page"
        @update:modelValue="movePage(props.lectures.current_page)"
      />
      <div class="text-center text-caption mt-1" style="color: #26A69A;">
        {{ props.lectures.total }}件中 {{ props.lectures.from }}~{{ props.lectures.to }}件目表示中
      </div>
    </template>
  </PageSection>

    <ConfirmCard
      :dialog="deleteDialog"
      title="講義削除"
      subtitle="本当に削除してもよろしいですか？"
      text="削除した情報の復元には時間がかかります。"
      :items="deleteLectureContent"
    >
      <template v-slot:cancelBtn>
        <SecondaryBtn @click="deleteDialog = false">いいえ</SecondaryBtn>
      </template>
      <template v-slot:okBtn>
        <PrimaryBtn color="#D50000" @click="[deleteDialog = false, deleteLecture()]">はい</PrimaryBtn>
      </template>
    </ConfirmCard>

    <ConfirmCard
      :dialog="reportDialog"
      title="不適切な投稿として報告"
      subtitle="報告する講義に間違いはありませんか？"
      text="頻繁に報告される講義は管理者の判断により削除します。"
      :items="reportLectureContent"
    >
      <template v-slot:cancelBtn>
        <SecondaryBtn @click="reportDialog = false">いいえ</SecondaryBtn>
      </template>
      <template v-slot:okBtn>
        <PrimaryBtn @click="[reportDialog = false, report()]">はい</PrimaryBtn>
      </template>
    </ConfirmCard>
</template>