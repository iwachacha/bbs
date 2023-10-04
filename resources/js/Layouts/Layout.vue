<script setup>
  import { ref } from 'vue'
  import { mdiHome, mdiAccountCircle, mdiSchool, mdiAccountQuestionOutline, mdiPenPlus, mdiHumanMaleBoard, mdiChatProcessingOutline, mdiSilverwareForkKnife, mdiMessageText } from '@mdi/js'
  import { usePage, Link, router } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"
  import { getFacultyName } from '@/Components/Lectures/GetNameFromId.vue'
  import NavAvatar from '@/Components/NavAvatar.vue'
  import NavItem from '@/Components/NavItem.vue'
  import ConfirmCard from '@/Components/ConfirmCard.vue'
  import PrimaryBtn from '@/Components/PrimaryBtn.vue'
  import SecondaryBtn from '@/Components/SecondaryBtn.vue'

  const user = usePage().props.auth.user
  const drawer = ref(false)
  const open = ref([null])
  const dialog = ref(false)
</script>

<template>
    <v-app style="background-color: #F5F5F5;">
      <v-navigation-drawer v-model="drawer" color="secondary">
        <NavAvatar
          :name="(user) ? user.name : 'ゲストさん'"
          :faculty="user && getFacultyName($page.props.share.faculties, user.faculty_id)"
          :grade="user && user.grade"
        />

        <v-divider class="border-opacity-100" />

        <v-list nav v-model:opened="open">
          <NavItem
            :href="'/'"
            title="ホーム"
            :icon="mdiHome"
            component="Home"
          />

          <v-list-group value="lectures">
            <template v-slot:activator="{ props }">
              <v-list-item
                v-bind="props"
                :prepend-icon="mdiSchool"
                title="講義評価"
                rounded="xl"
                color="primary"
                :active="$page.component.startsWith('Lecture') || $page.component.startsWith('Review')"
              />
            </template>

            <NavItem
              :href="route('lecture.index')"
              title="講義検索"
              :icon="mdiHumanMaleBoard"
              component="Lecture/Index"
            />

            <NavItem
              :href="route('review.index')"
              title="レビュー検索"
              :icon="mdiMessageText"
              component="Review/Index"
            />

            <NavItem
              :href="route('lecture.create')"
              title="レビュー作成"
              :icon="mdiPenPlus"
              component="Lecture/Create"
            />
          </v-list-group>

          <NavItem
            :href="route('chat.index')"
            :icon="mdiChatProcessingOutline "
            title="雑談部屋"
            component="Chat/Index"
          />

          <NavItem
            :href="route('contact.create')"
            :icon="mdiSilverwareForkKnife"
            title="周辺グルメ（開発予定）"
          />

          <NavItem
            :href="route('contact.create')"
            :icon="mdiAccountQuestionOutline"
            title="お問い合わせ"
            component="Contact/Create"
          />
        </v-list>

        <template v-slot:append>
          <template v-if="user">
            <div class="pa-2">
              <v-btn color="primary" block @click="dialog = true">
                ログアウト
              </v-btn>
            </div>

            <ConfirmCard
              :dialog="dialog"
              title="ログアウト"
              subtitle="ログアウトしますか？"
            >
              <template v-slot:cancelBtn>
                <SecondaryBtn @click="dialog = false">いいえ</SecondaryBtn>
              </template>
              <template v-slot:okBtn>
                <PrimaryBtn
                  @click="[
                    router.post(route('logout'), {
                      onSuccess: () => {
                        useToast().success('ログアウトが完了しました。')
                        router.reload()
                      }
                    }),
                    dialog = false
                  ]"
                >
                  ログアウト
                </PrimaryBtn>
              </template>
            </ConfirmCard>
          </template>
        </template>
      </v-navigation-drawer>

      <v-app-bar color="primary">
        <v-app-bar-nav-icon @click="drawer = !drawer" size="x-large" class="ms-0 ms-sm-2 ms-md-4" />
        <h1><v-app-bar-title class="text-h5">文教掲示板</v-app-bar-title></h1>

        <template v-slot:append>
          <template v-if="user">
            <Link :href="route('lecture.create')" class="me-3 me-sm-4">
              <v-icon :icon="mdiPenPlus" />投稿
            </Link>

            <v-menu>
              <template v-slot:activator="{ props }">
                <v-icon
                  v-bind="props"
                  :icon="mdiAccountCircle"
                  size="38"
                  class="me-2"
                />
              </template>

              <v-list>
                <Link :href="route('profile.edit')">
                  <v-list-item link title="アカウント情報" />
                </Link>
                <v-divider class="border-opacity-100" />

                <v-list-item link title="プロフィール" ></v-list-item>
              </v-list>
            </v-menu>
          </template>

          <template v-else>
            <Link :href="route('login')">
              <v-btn class="pe-1">ログイン</v-btn>
            </Link>

            <Link :href="route('register')">
              <v-btn class="ps-1 pe-2">新規登録</v-btn>
            </Link>
          </template>
        </template>
      </v-app-bar>

      <v-main class="mx-auto mb-10" style="width: 100%; overflow: hidden;">
        <slot />
      </v-main>
    </v-app>
</template>