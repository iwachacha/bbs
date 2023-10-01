<script setup>
  import { ref } from 'vue'
  import { mdiSchool, mdiChatQuestion, mdiPenPlus, mdiHumanMaleBoard, mdiChat, mdiSilverwareForkKnife, mdiMessageText } from '@mdi/js'
  import { usePage, Link } from '@inertiajs/vue3'
  import NavAvatar from '@/Components/NavAvatar.vue'
  import NavItem from '@/Components/NavItem.vue'
  import { getFacultyName } from '@/Components/Lectures/GetNameFromId.vue'

  const pageProps = usePage().props

  const drawer = ref(false)
  const nav = ref(null)
</script>

<template>
    <v-app style="background-color: #F5F5F5;">

      <v-navigation-drawer v-model="drawer" color="secondary">

        <NavAvatar
          :name="pageProps.auth.user.name"
          :faculty="getFacultyName(pageProps.share.faculties, pageProps.auth.user.faculty_id)"
          :grade="pageProps.auth.user.grade"
        />

        <v-divider class="border-opacity-100" />

        <v-list nav v-model:opened="nav">

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
              :href="route('admin.lecture.index')"
              title="講義検索"
              :icon="mdiHumanMaleBoard"
              component="Lecture/Index"
            />
            <NavItem
              :href="route('admin.review.index')"
              title="レビュー検索"
              :icon="mdiMessageText"
              component="Review/Index"
            />
          </v-list-group>

          <NavItem
            :href="route('admin.lecture.index')"
            :icon="mdiSilverwareForkKnife"
            title="周辺グルメ（開発予定）"
          />
          
          <NavItem
            :href="route('admin.lecture.index')"
            :icon="mdiChat"
            title="雑談部屋（開発予定）"
          />

          <NavItem
            :href="route('admin.lecture.index')"
            :icon="mdiChatQuestion"
            title="お問い合わせ"
          />

        </v-list>

        <template v-slot:append>
          <div class="pa-2">
            <Link :href="route('admin.logout')" method="post" as="button" style="width: 100%;">
              <v-btn color="primary" block>
                ログアウト
              </v-btn>
            </Link>
          </div>
        </template>

      </v-navigation-drawer>

      <v-app-bar color="primary">
        <v-app-bar-nav-icon @click="drawer = !drawer" size="x-large" />
        <h1><v-app-bar-title class="text-h5">文教掲示板</v-app-bar-title></h1>
      </v-app-bar>

      <v-main class="mx-auto" style="width: 100%; overflow: hidden;">
        <slot />
      </v-main>

    </v-app>

</template>