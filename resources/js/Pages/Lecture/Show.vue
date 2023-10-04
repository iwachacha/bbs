<script setup>
  import { ref, computed } from 'vue'
  import { router, Head } from '@inertiajs/vue3'
  import { mdiMessageText, mdiSquareEditOutline, mdiTrashCan, mdiAlertCircle, mdiAccountCircle } from '@mdi/js'
  import { useToast } from "vue-toastification"
  import PageSection from '@/Components/PageSection.vue'
  import StarRate from '@/Components/StarRate.vue'
  import Carousel from '@/Components/Carousel.vue'
  import PostCard from '@/Components/PostCard.vue'
  import LinkBtn from '@/Components/LinkBtn.vue'
  import StarRateChip from '@/Components/StarRateChip.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'
  import FilterReviewForm from '@/Components/Reviews/FilterReviewForm.vue'
  import SortReviewForm from '@/Components/Reviews/SortReviewForm.vue'
  import ReviewQueryChip from '@/Components/Reviews/ReviewQueryChip.vue'
  import GoodBtn from '@/Components/Reviews/ReviewGoodBtn.vue'
  import { getReviewContent } from '@/Components/Reviews/GetReviewContent.vue'
  import { fulfillmentRatingCount, easeRatingCount, satisfactionRatingCount } from '@/Components/Reviews/GetRatingCount.vue'

  const props = defineProps({
    lecture: Object,
    fulfillmentRatings: Array,
    easeRatings: Array,
    satisfactionRatings: Array,
    reviews: Object,
    resultCount: Number,
    query: Object
  })

  const tab = ref('reviews')

  const PostBarTitle = computed(() => (userName, userFacultyId) => {
    switch (userFacultyId) {
      case 1: return userName + 'さん（教育学部）の評価'
      case 2: return userName + 'さん（人間科学部）の評価'
      case 3: return userName + 'さん（文学部）の評価'
      default: return userName + 'さんの評価'
    }
  })

  //レビュー削除
  const deleteDialog = ref(false)
  const deleteReviewId = ref(null)
  const deleteReviewContent = ref(null)

  const deleteConfirm = (reviewId) => {
    deleteReviewContent.value = getReviewContent(props.reviews, reviewId)
    deleteDialog.value = true
  }

  const deleteReview = () => {
    router.delete(route('review.delete', deleteReviewId.value), {
      preserveScroll: true,
      onSuccess: (page) => {
        page.props.flash.error
          ? useToast().error(page.props.flash.error)
          : useToast().success('レビューの削除が完了しました。')
        deleteReviewId.value = null
        deleteReviewContent.value = null
      },
    })
  }

  //レビュー報告
  const reportDialog = ref(false)
  const reportReviewId = ref(null)
  const reportReviewContent = ref(null)

  const reportConfirm = (reviewId) => {
    reportReviewContent.value = getReviewContent(props.reviews, reviewId)
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

  //重複なしタグ一覧
  const tagNames = []
  props.reviews.forEach(review => {
    review.tags.forEach(tag => {
      tagNames.push(tag.name)
    })
  })
  const uniqueTagNames = Array.from(new Set(tagNames))

  //レビューのタグ検索
  const tagSearch = (name) => {
    router.get(route('review.index', { tag: name }), {}, {
      onSuccess: () => {
        useToast().success('＃' + name + 'でレビューを検索しました。')
      }
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
  <Head :title="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + ' - レビュー・講義情報'" />

  <PageSection
    title="レビュー・講義情報"
    :subtitle="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + 'のレビュー・講義情報です。'"
    :icon="mdiMessageText"
  >
    <v-tabs
      v-model="tab"
      color="primary"
      align-tabs="center"
      grow
      style="border-bottom: 1px solid #BDBDBD;"
    >
      <v-tab value="reviews">レビュー</v-tab>
      <v-tab value="rateAverage">平均評価</v-tab>
      <v-tab value="lectureInformation">講義情報</v-tab>
    </v-tabs>

    <div class="text-right my-3 me-sm-5">
      <LinkBtn variant="text" :href="route('review.create', props.lecture.id)">
        この講義を評価する
      </LinkBtn>
    </div>

    <v-window v-model="tab">
      <v-window-item value="reviews">
        <template v-if="Object.keys(props.reviews).length">
          <div class="d-flex justify-end me-sm-5">
            <div class="me-3">
              <FilterReviewForm
                :query="props.query"
                :result-count="props.resultCount"
                route-name="lecture.show"
                :route-param="props.lecture.id"
                :only="['reviews', 'resultCount', 'query']"
              />
            </div>

            <SortReviewForm
              :query="props.query"
              route-name="lecture.show"
              :route-param="props.lecture.id"
              :only="['reviews', 'query']"
            />
          </div>
        </template>

        <ReviewQueryChip
          :query="props.query"
          route-name="lecture.show"
          :route-param="lecture.id"
          :only="['reviews', 'resultCount', 'query']"
          :total-count="props.lecture.reviews_count"
          :result-count="props.resultCount"
        />

        <v-row justify="center" class="mt-0">
          <template v-for="review in props.reviews">
            <v-col cols="12" sm="10" md="6">
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
                  {{ review.title }}
                </template>

                <template v-slot:subtitle>
                  {{ review.year + '受講 / ' + review.created_at + ' 投稿' }}
                </template>

                <template v-slot:text>
                  <v-row justify="center" align="center" class="mt-0">
                    <v-col cols="auto" class="py-2">
                      <StarRateChip
                        label="充実度評価"
                        :star="review.fulfillment_rate"
                      />
                    </v-col>

                    <v-col cols="auto" class="py-2">
                      <StarRateChip
                        label="楽単度評価"
                        :star="review.ease_rate"
                      />
                    </v-col>

                    <v-col cols="auto" class="py-2">
                      <StarRateChip
                        label="満足度評価"
                        :star="review.satisfaction_rate"
                      />
                    </v-col>
                  </v-row>
                </template>

                <template v-slot:readMoreContent>
                  <v-label class="text-subtitle-2">＃タグ</v-label>
                  <div class="my-2">
                    <span v-if="!Object.keys(review.tags).length">なし</span>
                    <template v-else>
                      <span v-for="tag in review.tags"
                        style="color: #26A69A;"
                        class="mx-2"
                        @click="tagSearch(tag.name)"
                      >
                        {{ '#' + tag.name }}
                      </span>
                    </template>
                  </div>
                  <v-divider class="border-opacity-100 mb-5" />

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
                    {{ review.review_good ? review.review_good.count : 0 }}回の共感が寄せられています！
                  </div>
                  <v-spacer />

                  <template v-if="review.user_id !== $page.props.auth.user.id">
                    <GoodBtn :review-id="review.id" />
                  </template>
                </template>

              </PostCard>
            </v-col>
          </template>
        </v-row>
      </v-window-item>

      <v-window-item value="rateAverage" style="border: 1px solid #BDBDBD; background-color: #EEEEEE;">
        <v-row align="center" class="pt-10 pb-5">
          <v-col cols="12" md="5">
            <div color="secondary">
              <div class="text-center mt-auto text-h5">
                総合評価
              </div>

              <div class="d-flex align-center flex-column">
                <div class="text-h5 mt-5">
                  {{ Math.floor(props.lecture.average_rate * 100) / 100 }}
                  <span class="text-subtitle-2 text-medium-emphasis ml-n1">/ 5</span>
                </div>
                <span class="text-subtitle-2 mt-2 text-medium-emphasis">（{{ props.lecture.reviews_count }}件中）</span>

                <v-rating
                  :model-value="props.lecture.average_rate"
                  color="primary"
                  size="x-large"
                  density="compact"
                  half-increments
                  readonly
                  class="mt-3"
                />
              </div>
            </div>
          </v-col>
          <v-divider class="border-opacity-100 d-md-none my-3" />

          <v-col cols="12" md="7">
            <Carousel>
              <div class="px-2">
                <v-carousel-item>
                  <StarRate
                    title="平均充実度評価"
                    :average="Math.floor(props.lecture.fulfillment_rate_avg * 100) / 100"
                    :total-count="lecture.reviews_count"
                    :valueCounts="fulfillmentRatingCount(props.fulfillmentRatings)"
                  />
                </v-carousel-item>
                <v-carousel-item>
                  <StarRate
                    title="平均楽単度評価"
                    :average="Math.floor(props.lecture.ease_rate_avg * 100) / 100"
                    :total-count="lecture.reviews_count"
                    :valueCounts="easeRatingCount(props.easeRatings)"
                  />
                </v-carousel-item>
                <v-carousel-item>
                  <StarRate
                    title="平均満足度評価"
                    :average="Math.floor(props.lecture.satisfaction_rate_avg * 100) / 100"
                    :total-count="lecture.reviews_count"
                    :valueCounts="satisfactionRatingCount(props.satisfactionRatings)"
                  />
                </v-carousel-item>
              </div>
            </Carousel>
          </v-col>

        </v-row>
      </v-window-item>

      <v-window-item value="lectureInformation">
        <v-table density="compact">
          <tbody>
            <tr><th>講義名</th><td>{{ props.lecture.lecture_name }}</td></tr>
            <tr><th>担当教員名</th><td>{{ props.lecture.professor_name }}</td></tr>
            <tr><th>開講時期</th><td>{{ props.lecture.season }}</td></tr>
            <tr><th>講義区分</th><td>{{ props.lecture.lecture_category.name  }}</td></tr>
            <tr><th>開講学部</th><td>{{ props.lecture.faculty ? lecture.faculty.name : '未設定' }}</td></tr>
            <tr><th>開講学科・課程</th><td>{{ props.lecture.department ? lecture.department.name : '未設定' }}</td></tr>
            <tr><th>開講コース・専修</th><td>{{ props.lecture.course ? lecture.course.name : '未設定'}}</td></tr>
            <tr>
              <th>＃タグ一覧</th>
              <td>
                <v-row justify="center" class="pa-2 ma-0">
                  <span v-if="!uniqueTagNames.length">なし</span>
                  <template v-else>
                    <template v-for="tag in uniqueTagNames">
                      <v-col cols="auto" class="py-0 px-2">
                        <span @click="tagSearch(tag)" style="color: #26A69A;">{{ '＃' + tag }}</span>
                      </v-col>
                    </template>
                  </template>
                </v-row>
              </td>
            </tr>
            <tr><th>投稿日時</th><td>{{ props.lecture.created_at }}</td></tr>
          </tbody>
        </v-table>
      </v-window-item>
    </v-window>

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

<style>
  th {
    background-color: #4DB6AC;
    color: #FAFAFA;
    width: 30%;
    text-align: center !important;
    padding: 0 2px !important;
  }

  td {
    background-color: #EEEEEE;
    text-align: center !important;
    padding: 0 2px !important;
  }
</style>