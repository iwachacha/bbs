<script setup>
  import { mdiMessageText } from '@mdi/js'
  import PageSection from '@/Components/PageSection.vue'

  const props = defineProps({
    lecture: Object,
  })
</script>

<script>
  import Layout from '@/Layouts/Layout.vue'
  export default {
    layout: Layout,
  }
</script>

<template>
  <PageSection
    :title="props.lecture.lecture_name + ' / ' + props.lecture.professor_name + 'のレビュー'"
    :icon="mdiMessageText"
  >
  <v-sheet elevation="1" color="secondary" class="pt-7">
    <v-row align="center">
      <v-col cols="12" md="8">
        <v-sheet color="secondary">
          <div class="text-center mt-auto text-h5 ">
            総合平均評価
          </div>

          <div class="d-flex align-center flex-column">
            <div class="text-h4 mt-5">
              3.5
              <span class="text-h6 ml-n2">/5</span>
            </div>
            <span class="text-caption">（1件中）</span>

            <v-rating
              :model-value="3.5"
              color="primary"
              size="large"
              half-increments
              readonly
            ></v-rating>
          </div>

          <v-list
            bg-color="transparent"
            class="d-flex flex-column-reverse"
            density="compact"
          >

            <v-list-item v-for="(rating,i) in 5" :key="i" class="pa-0">
              <v-row justify="center">

                <v-col cols="1" class="px-0 text-right">
                  <span>☆{{ rating }}</span>
                </v-col>

                <v-col cols="9" class="px-3">
                  <v-progress-linear
                    :model-value="rating * 15"
                    color="#4DB6AC"
                    height="15"
                    rounded
                  />
                </v-col>

                <v-col cols="1" class="px-0 text-left">
                  <span> {{ rating * 15 }} </span>
                </v-col>

              </v-row>
            </v-list-item>
          </v-list>
        </v-sheet>
      </v-col>
      <v-col cols="12" md="4">
        <v-carousel
          cycle="true"
          height="auto"
          hide-delimiter-background
          show-arrows="hover"
        >
          <v-carousel-item>
            <v-sheet
              color="secondary"
            >
              <div class="text-center mt-auto text-h5 ">
                楽単度平均評価
              </div>

              <div class="d-flex align-center flex-column">
                <div class="text-h4 mt-5">
                  3.5
                  <span class="text-h6 ml-n2">/5</span>
                </div>
                <span class="text-caption">（1件中）</span>

                <v-rating
                  :model-value="3.5"
                  color="primary"
                  size="large"
                  half-increments
                  readonly
                ></v-rating>
              </div>

              <v-list
                bg-color="transparent"
                class="d-flex flex-column-reverse"
                density="compact"
              >

                <v-list-item v-for="(rating,i) in 5" :key="i" class="pa-0">
                  <v-row justify="center">

                    <v-col cols="2" class="px-0 text-right">
                      <span>☆ {{ rating }}</span>
                    </v-col>

                    <v-col cols="7" class="px-3">
                      <v-progress-linear
                        :model-value="rating * 15"
                        color="#4DB6AC"
                        height="15"
                        rounded
                      />
                    </v-col>

                    <v-col cols="2" class="px-0 text-left">
                      <span> {{ rating * 22 }} </span>
                    </v-col>

                  </v-row>
                </v-list-item>
              </v-list>
            </v-sheet>
          </v-carousel-item>
          <v-carousel-item>
            <v-sheet
              color="secondary"
            >
              <div class="text-center mt-auto text-h5 ">
                充実度平均評価
              </div>

              <div class="d-flex align-center flex-column">
                <div class="text-h4 mt-5">
                  3.5
                  <span class="text-h6 ml-n2">/5</span>
                </div>
                <span class="text-caption">（1件中）</span>

                <v-rating
                  :model-value="3.5"
                  color="primary"
                  size="large"
                  half-increments
                  readonly
                ></v-rating>
              </div>

              <v-list
                bg-color="transparent"
                class="d-flex flex-column-reverse"
                density="compact"
              >

                <v-list-item v-for="(rating,i) in 5" :key="i" class="pa-0">
                  <v-row justify="center">

                    <v-col cols="2" class="px-0 text-right">
                      <span>☆ {{ rating }}</span>
                    </v-col>

                    <v-col cols="7" class="px-3">
                      <v-progress-linear
                        :model-value="rating * 15"
                        color="#4DB6AC"
                        height="15"
                        rounded
                      />
                    </v-col>

                    <v-col cols="2" class="px-0 text-left">
                      <span> {{ rating * 22 }} </span>
                    </v-col>

                  </v-row>
                </v-list-item>
              </v-list>
            </v-sheet>
          </v-carousel-item>
          <v-carousel-item>
            <v-sheet
              color="secondary"
            >
              <div class="text-center mt-auto text-h5 ">
                満足度平均評価
              </div>

              <div class="d-flex align-center flex-column">
                <div class="text-h4 mt-5">
                  3.5
                  <span class="text-h6 ml-n2">/5</span>
                </div>
                <span class="text-caption">（1件中）</span>

                <v-rating
                  :model-value="3.5"
                  color="primary"
                  size="large"
                  half-increments
                  readonly
                ></v-rating>
              </div>

              <v-list
                bg-color="transparent"
                class="d-flex flex-column-reverse"
                density="compact"
              >

                <v-list-item v-for="(rating,i) in 5" :key="i" class="pa-0">
                  <v-row justify="center">

                    <v-col cols="2" class="px-0 text-right">
                      <span>☆ {{ rating }}</span>
                    </v-col>

                    <v-col cols="7" class="px-3">
                      <v-progress-linear
                        :model-value="rating * 15"
                        color="#4DB6AC"
                        height="15"
                        rounded
                      />
                    </v-col>

                    <v-col cols="2" class="px-0 text-left">
                      <span> {{ rating * 22 }} </span>
                    </v-col>

                  </v-row>
                </v-list-item>
              </v-list>
            </v-sheet>
          </v-carousel-item>
        </v-carousel>
      </v-col>
    </v-row>
  </v-sheet>
  </PageSection>
</template>
