<script setup>
  import { ref } from 'vue'
  import { mdiHome, mdiAccountCircle, mdiSchool, mdiHelpCircleOutline, mdiPenPlus, mdiHumanMaleBoard, mdiChatProcessingOutline, mdiMessageText, mdiMapMarkerRadius } from '@mdi/js'
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

  const component = usePage().component
  const open = (component.startsWith('Lecture') || component.startsWith('Review'))
    ? ref(['lectures'])
    : ref([null])

  const dialog = ref(false)
</script>

<template>
  <v-app style="background-color: #F5F5F5;">
    <v-navigation-drawer v-model="drawer" color="secondary" temporary>
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
          :active="component === 'Home'"
        />

        <v-list-group value="lectures">
          <template v-slot:activator="{ props }">
            <v-list-item
              v-bind="props"
              :prepend-icon="mdiSchool"
              title="講義情報"
              rounded="xl"
              color="primary"
              :active="component.startsWith('Lecture') || component.startsWith('Review')"
            />
          </template>

          <NavItem
            :href="route('lecture.index')"
            title="講義検索"
            :icon="mdiHumanMaleBoard"
            :active="component === 'Lecture/Index'"
          />

          <NavItem
            :href="route('review.index')"
            title="レビュー検索"
            :icon="mdiMessageText"
            :active="component === 'Review/Index'"
          />

          <NavItem
            :href="route('lecture.create')"
            title="レビュー作成"
            :icon="mdiPenPlus"
            :active="component === 'Lecture/Create'"
          />
        </v-list-group>

        <NavItem
          :href="route('chat.index')"
          :icon="mdiChatProcessingOutline "
          title="雑談部屋"
          :active="component.startsWith('Chat')"
        />

        <NavItem
          :href="route('contact.create')"
          :icon="mdiMapMarkerRadius"
          title="周辺スポット(開発予定)"
        />

        <NavItem
          :href="route('contact.create')"
          :icon="mdiHelpCircleOutline"
          title="お問い合わせ"
          :active="component.startsWith('Contact')"
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
                  router.post(route('logout'), {}, {
                    preserveState: false,
                    onSuccess: () => {
                      useToast().success('ログアウトが完了しました。')
                    }
                  }),
                  dialog = false,
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
              <Link :href="route('profile.show', user.id)">
                <v-list-item link title="プロフィール" />
              </Link>

              <v-divider class="border-opacity-100" />

              <Link :href="route('profile.edit')">
                <v-list-item link title="アカウント情報" />
              </Link>
            </v-list>
          </v-menu>
        </template>

        <template v-else>
          <Link :href="route('login')">
            <v-btn class="px-1">ログイン</v-btn>
          </Link>

          <Link :href="route('register')">
            <v-btn class="px-1 me-sm-2">新規登録</v-btn>
          </Link>
        </template>
      </template>
    </v-app-bar>

    <v-main class="mb-10 mx-auto" style="width: 100%; overflow: hidden;">
      <slot />
    </v-main>
  </v-app>
</template>