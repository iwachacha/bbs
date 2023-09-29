<script setup>
  import { ref, computed } from 'vue'
  import { Link, router, Head } from '@inertiajs/vue3'
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

  const props = defineProps({
    lecture: Object,
    fulfillmentRate: Array,
    easeRate: Array,
    satisfactionRate: Array,
  })

  const tab = ref('reviews')

  //☆1~5それぞれの合計数を返す counts = [☆1の数, ☆2の数..., ☆5の数]
  const fulfillmentRateCounts = computed(() => {
    let counts = []
    for(let i = 1; i <= 5; i++){
      let target = props.fulfillmentRate.find((value) => value.fulfillment_rate == i)
      target ? counts.push(target.count) : counts.push(0)
    }
    return counts
  })

  const easeRateCounts = computed(() => {
    let counts = []
    for(let i = 1; i <= 5; i++){
      let target = props.easeRate.find((value) => value.ease_rate == i)
      target ? counts.push(target.count) : counts.push(0)
    }
    return counts
  })

  const satisfactionRateCounts = computed(() => {
    let counts = []
    for(let i = 1; i <= 5; i++){
      let target = props.satisfactionRate.find((value) => value.satisfaction_rate == i)
      target ? counts.push(target.count) : counts.push(0)
    }
    return counts
  })

  const PostBarTitle = computed(() => (userName, userFacultyId) => {
    switch (userFacultyId) {
      case 1: return userName + 'さん（教育学部）の評価'
      case 2: return userName + 'さん（人間科学部）の評価'
      case 3: return userName + 'さん（文学部）の評価'
      default: return userName + 'さんの評価'
    }
  })

  const deleteDialog = ref(false)
  const deleteId = ref(null)

  const deleteReview = () => {
    router.delete(route('review.delete', deleteId.value), {
      preserveScroll: true,
      onSuccess: () => {
        useToast().success('レビューの削除が完了しました。')
        deleteId.value = null
      },
      only: ['lecture']
    })
  }

  const tagNames = []
  props.lecture.reviews.forEach(review => {
    review.tags.forEach(tag => {
      tagNames.push(tag.name)
    })
  })
  const uniqueTagNames = Array.from(new Set(tagNames))

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
    :title="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + ' - レビュー・講義情報'"
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

    <div class="text-right my-3">
      <LinkBtn variant="text" :href="route('review.create', props.lecture.id)">
        この講義を評価する
      </LinkBtn>
    </div>

    <v-window v-model="tab">
      <v-window-item value="reviews">
        <v-row justify="center">
          <template v-for="review in props.lecture.reviews">
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
                  <Link :href="route('review.edit', [props.lecture.id, review.id])">
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
                  {{ review.title }}
                </template>

                <template v-slot:subtitle>
                  {{ review.year + '受講 / ' + review.created_at + ' 投稿' }}
                </template>

                <template v-slot:text>
                  <v-row justify="center" align="center">
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
                    <template v-if="review.tags.length">
                        <v-label class="text-subtitle-2">＃タグ</v-label>
                        <div class="my-2">
                          <span v-for="tag in review.tags"
                            style="color: #26A69A;"
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
                  <span class="ms-2 text-caption">
                    1人の学生に共感されています
                  </span>
                  <v-spacer />
                  <LinkBtn>それな！</LinkBtn>
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
                平均総合評価
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
              <div class="px-14">
                <v-carousel-item>
                  <StarRate
                    title="平均充実度評価"
                    :average="Math.floor(props.lecture.fulfillment_rate_avg * 100) / 100"
                    :total-count="lecture.reviews_count"
                    :valueCounts="fulfillmentRateCounts"
                  />
                </v-carousel-item>
                <v-carousel-item>
                  <StarRate
                    title="平均楽単度評価"
                    :average="Math.floor(props.lecture.ease_rate_avg * 100) / 100"
                    :total-count="lecture.reviews_count"
                    :valueCounts="easeRateCounts"
                  />
                </v-carousel-item>
                <v-carousel-item>
                  <StarRate
                    title="平均満足度評価"
                    :average="Math.floor(props.lecture.satisfaction_rate_avg * 100) / 100"
                    :total-count="lecture.reviews_count"
                    :valueCounts="satisfactionRateCounts"
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
                  <template v-for="tag in uniqueTagNames">
                    <v-col cols="auto" class="py-0 px-2">{{ '＃' + tag }}</v-col>
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
  >
    <template v-slot:cancelBtn>
      <SecondaryBtn @click="deleteDialog = false">いいえ</SecondaryBtn>
    </template>
    <template v-slot:okBtn>
      <PrimaryBtn color="#D50000" @click="[deleteDialog = false, deleteReview()]">はい</PrimaryBtn>
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