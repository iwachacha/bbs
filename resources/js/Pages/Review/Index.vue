<script setup>
  import { computed, ref } from 'vue'
  import { Head, Link } from '@inertiajs/vue3'
  import { mdiMessageText, mdiAlertCircle, mdiAccountCircle, mdiChevronRight, mdiSquareEditOutline, mdiTrashCan } from '@mdi/js'
  import { router } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import PageSection from '@/Components/PageSection.vue'
  import PostCard from '@/Components/PostCard.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import StarRateChip from '@/Components/StarRateChip.vue'
  import PaginationBtn from '@/Components/PaginationBtn.vue'
  import SearchReviewForm from '@/Components/Reviews/SearchReviewForm.vue'
  import FilterReviewForm from '@/Components/Reviews/FilterReviewForm.vue'
  import SortReviewForm from '@/Components/Reviews/SortReviewForm.vue'
  import ReviewQueryChip from '@/Components/Reviews/ReviewQueryChip.vue'
  import GoodBtn from '@/Components/Reviews/ReviewGoodBtn.vue'
  import { getReviewContent } from '@/Components/Reviews/GetReviewContent.vue'

  const props = defineProps({
    reviews: Object,
    query: Object,
    totalCount: Number
  })

  const PostBarTitle = computed(() => (userName, userFacultyId) => {
    switch (userFacultyId) {
      case 1: return userName + 'さん（教育学部）の評価'
      case 2: return userName + 'さん（人間科学部）の評価'
      case 3: return userName + 'さん（文学部）の評価'
      default: return userName + 'さんの評価'
    }
  })

  //＃タグ検索
  const tagSearch = (name) => {
    router.get(route('review.index', { tag: name }), {}, {
      onSuccess: () => {
        useToast().success('＃' + name + 'でレビューを検索しました。')
      }
    })
  }

  //ページネーション
  const movePage = (targetPage) => {
    router.get(props.reviews.links[targetPage].url,
    props.query, {
      preserveState: true,
      only: ['reviews', 'query'],
    })
  }

  //レビュー削除
  const deleteDialog = ref(false)
  const deleteReviewId = ref(null)
  const deleteReviewContent = ref(null)

  const deleteConfirm = (reviewId) => {
    deleteReviewContent.value = getReviewContent(props.reviews.data, reviewId)
    deleteDialog.value = true
  }

  const deleteReview = () => {
    router.delete(route('review.delete', deleteReviewId.value), {
      preserveScroll: true,
      onSuccess: (page) => {[
        page.props.flash.error
          ? useToast().error(page.props.flash.error)
          : useToast().success('レビューの削除が完了しました。'),
        deleteReviewId.value = null,
        deleteReviewContent.value = null
      ]},
    })
  }

  //レビュー報告
  const reportDialog = ref(false)
  const reportReviewId = ref(null)
  const reportReviewContent = ref(null)

  const reportConfirm = (reviewId) => {
    reportReviewContent.value = getReviewContent(props.reviews.data, reviewId)
    reportDialog.value = true
  }

  const report = () => {
    router.post(route('report'), {
      review_id: reportReviewId.value
    }, {
      preserveScroll: true,
      onSuccess: () => {
        useToast().success('不適切な投稿として報告されました。')
        reportReviewId.value = null
        reportReviewContent.value = null
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
  <Head title="レビュー検索" />

  <PageSection
    :icon="mdiMessageText"
    title="レビュー検索"
    subtitle="寄せられたレビューはこちらから探すことができます。"
    :guest-viewing="false"
  >
    <v-row justify="center">
      <v-col cols="11" sm="9" md="7" class="pa-0">
        <SearchReviewForm
          :query="props.query"
          :result-count="props.reviews.total"
        />
      </v-col>
    </v-row>

    <div class="d-flex justify-end mt-7 me-sm-5">
      <div class="me-3">
        <FilterReviewForm
          :query="props.query"
          route-name="review.index"
          :result-count="props.reviews.total"
          :only="['reviews', 'query', 'resultCount']"
        />
      </div>

      <SortReviewForm
        :query="props.query"
        route-name="review.index"
        :only="['reviews', 'query']"
      />
    </div>

    <ReviewQueryChip
      :query="props.query"
      route-name="review.index"
      :only="['reviews', 'query', 'resultCount']"
      :total-count="props.totalCount"
      :result-count="props.reviews.total"
    />

    <v-row justify="center" class="mt-0">
      <template v-for="review in props.reviews.data">
        <v-col cols="12" sm="10" md="6" class="py-2 py-sm-3">
          <PostCard
            :read-more="true"
            class="mb-4"
          >
            <template v-slot:barTitle>
              <v-icon :icon="mdiAccountCircle"
                size="large"
              />
              {{ PostBarTitle(review.user.name, review.user.faculty_id) }}
            </template>

            <template v-slot:menuItem>
              <v-list-item
                v-if="review.user_id === $page.props.auth.user.id"
                link
                title="編集"
                :prepend-icon="mdiSquareEditOutline"
                style="color: #26A69A;"
                @click="router.get(route('review.edit', [review.lecture_id, review.id]), {} , {
                  preserveScroll: true,
                  onSuccess: (page) => {
                    page.props.flash.error && useToast().error(page.props.flash.error)
                  }
                })"
              />

              <v-list-item
                v-if="review.user_id === $page.props.auth.user.id"
                link
                title="削除"
                :prepend-icon="mdiTrashCan"
                style="color: red;"
                @click="[deleteConfirm(review.id), deleteReviewId = review.id]"
              />

              <v-list-item
                link
                title="不適切な投稿として報告"
                :prepend-icon="mdiAlertCircle"
                @click="[reportConfirm(review.id), reportReviewId = review.id]"
              />
            </template>

            <template v-slot:cardTitle>
              <Link :href="route('lecture.show', review.lecture_id)">
                {{ review.lecture.lecture_name + ' / ' + review.lecture.professor_name + '先生' }}
                <v-icon :icon="mdiChevronRight" size="x-small" class="ms-n1 text-disabled" />
              </Link>
            </template>

            <template v-slot:subtitle>
              {{ review.year + '受講 / ' + review.created_at + ' 投稿' }}
            </template>

            <template v-slot:text>
              <div class="text-subtitle-2">
                {{ review.title }}
              </div>

              <v-row justify="center" align="center" class="mt-1">
                <v-col cols="auto" class="py-1 px-2 px-sm-4">
                  <StarRateChip
                    label="充実度"
                    :star="review.fulfillment_rate"
                  />
                </v-col>

                <v-col cols="auto" class="py-1 px-2 px-sm-4">
                  <StarRateChip
                    label="楽単度"
                    :star="review.ease_rate"
                  />
                </v-col>

                <v-col cols="auto" class="py-1 px-2 px-sm-4">
                  <StarRateChip
                    label="満足度"
                    :star="review.satisfaction_rate"
                  />
                </v-col>
              </v-row>
            </template>

            <template v-slot:readMoreContent>
              <template v-if="review.tags.length">
                <v-label class="text-subtitle-2">＃タグ</v-label>
                <div class="my-2">
                  <span
                    v-for="tag in review.tags"
                    @click="tagSearch(tag.name)"
                    style="cursor: pointer; color: #26A69A;"
                    class="mx-2"
                  >
                    {{ '#' + tag.name }}
                  </span>
                </div>
                <v-divider class="border-opacity-100 mb-5" />
              </template>

              <v-label class="text-subtitle-2">講義内容</v-label>
              <div class="text-medium-emphasis mx-2 my-2">
                {{ review.lecture_content ? review.lecture_content : '未設定' }}
              </div>
              <v-divider class="border-opacity-100 mb-5" />

              <v-label class="text-subtitle-2">良い点</v-label>
              <div class="text-medium-emphasis mx-2 my-2">
                {{ review.good_point ? review.good_point : '未設定' }}
              </div>
              <v-divider class="border-opacity-100 mb-5" />

              <v-label class="text-subtitle-2">悪い点</v-label>
              <div class="text-medium-emphasis mx-2 my-2">
                {{ review.bad_point ? review.bad_point : '未設定' }}
              </div>
            </template>

            <template v-slot:action>
              <div class="ms-2 text-caption">
                {{ review.review_good ? review.review_good.count : 0 }}回の共感を受けています！
              </div>
              <v-spacer />

              <template v-if="$page.props.auth.user && review.user_id !== $page.props.auth.user.id">
                <GoodBtn :review-id="review.id" />
              </template>
            </template>
          </PostCard>
        </v-col>
      </template>
    </v-row>

    <template v-if="props.reviews.last_page > 1">
      <PaginationBtn
        v-model="props.reviews.current_page"
        :length="props.reviews.last_page"
        @update:modelValue="movePage(props.reviews.current_page)"
      />
      <div class="text-center text-caption mt-1" style="color: #26A69A;">
        {{ props.reviews.total }}件中 {{ props.reviews.from }}~{{ props.reviews.to }}件目表示中
      </div>
    </template>
  </PageSection>

  <ConfirmCard
    :dialog="deleteDialog"
    title="レビュー削除"
    subtitle="本当に削除してもよろしいですか？"
    text="削除した情報の復元には時間がかかります。"
    :items="deleteReviewContent"
  >
    <template v-slot:cancelBtn>
      <SecondaryBtn @click="deleteDialog = false">いいえ</SecondaryBtn>
    </template>
    <template v-slot:okBtn>
      <PrimaryBtn color="#D50000" @click="[deleteDialog = false, deleteReview()]">はい</PrimaryBtn>
    </template>
  </ConfirmCard>

  <ConfirmCard
    :dialog="reportDialog"
    title="不適切な投稿として報告"
    subtitle="報告するレビューに間違いはありませんか？"
    text="頻繁に報告されるレビューは管理者の判断により削除します。"
    :items="reportReviewContent"
  >
    <template v-slot:cancelBtn>
      <SecondaryBtn @click="reportDialog = false">いいえ</SecondaryBtn>
    </template>
    <template v-slot:okBtn>
      <PrimaryBtn @click="[reportDialog = false, report()]">はい</PrimaryBtn>
    </template>
  </ConfirmCard>
</template>