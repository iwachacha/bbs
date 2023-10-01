<script setup>
  import { computed, ref } from 'vue'
  import { Head, Link } from '@inertiajs/vue3'
  import { mdiMessageText, mdiMagnify, mdiAlertCircle, mdiAccountCircle, mdiChevronRight, mdiSquareEditOutline, mdiTrashCan } from '@mdi/js'
  import { router } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import LinkBtn from '@/Components/LinkBtn.vue'
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

  const props = defineProps({
    reviews: Object,
    query: Object
  })

  const pageSection = computed(() => {
    if(!Object.keys(props.query).length){
      return {
        icon: mdiMessageText,
        title: 'レビュー検索'
      }
    }
    else {
      return {
        icon: mdiMagnify,
        title: 'レビュー検索結果' + '（' + props.reviews.total + '件）'
      }
    }
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

  //レビュー削除
  const deleteDialog = ref(false)
  const deleteId = ref(null)

  const deleteReview = () => {
    router.delete(route('review.delete', deleteId.value), {
      preserveScroll: true,
      onSuccess: () => {
        useToast().success('レビューの削除が完了しました。')
        deleteId.value = null
      },
      only: ['reviews', 'query']
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
          :result-count="props.reviews.total"
        />
      </div>

      <SortReviewForm
        :query="props.query"
      />
    </div>

    <ReviewQueryChip
      :query="props.query"
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
              <Link :href="route('review.edit', [review.lecture_id, review.id])">
                <v-list-item
                  v-if="review.user_id === $page.props.auth.user.id"
                  link
                  :prepend-icon="mdiSquareEditOutline"
                  style="color: #26A69A;"
                >
                  <v-list-item-title class="align-center">編集</v-list-item-title>
                </v-list-item>
              </Link>

              <v-list-item
                v-if="review.user_id === $page.props.auth.user.id"
                link
                :prepend-icon="mdiTrashCan"
                style="color: red;"
                @click="[deleteDialog = true, deleteId = review.id]"
              >
                <v-list-item-title>削除</v-list-item-title>
              </v-list-item>

              <v-list-item link :prepend-icon="mdiAlertCircle">
                <v-list-item-title>不適切な投稿として報告</v-list-item-title>
              </v-list-item>
            </template>

            <template v-slot:cardTitle>
              <Link :href="route('lecture.show', [review.lecture_id, review.id])">
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
                1人の学生に共感されています
              </div>
              <v-spacer />
              <LinkBtn :href="route('review.index')">それな！</LinkBtn>
            </template>
          </PostCard>
        </v-col>
      </template>
    </v-row>

    <PaginationBtn
      v-model="props.reviews.current_page"
      :length="props.reviews.last_page"
      @update:modelValue="movePage(props.reviews.current_page)"
      v-if="props.reviews.last_page > 1"
    />
  </PageSection>

  <ConfirmCard
    :dialog="deleteDialog"
    title="レビュー削除"
    subtitle="本当に削除してもよろしいですか？"
    text="削除した情報の復元には時間がかかります。"
  >
    <template v-slot:cancelBtn>
      <SecondaryBtn @click="deleteDialog = false">いいえ</SecondaryBtn>
    </template>
    <template v-slot:okBtn>
      <PrimaryBtn color="#D50000" @click="[deleteDialog = false, deleteReview()]">はい</PrimaryBtn>
    </template>
  </ConfirmCard>
</template>