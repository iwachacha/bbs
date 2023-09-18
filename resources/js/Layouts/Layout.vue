<script setup>
  import { ref, computed } from 'vue'
  import { mdiSchool , mdiChatQuestion, mdiPenPlus, mdiListBox, mdiCrown, mdiChat } from '@mdi/js'
  import { usePage, Link } from '@inertiajs/vue3'
  import NavAvatar from '@/Components/NavAvatar.vue'
  import NavItem from '@/Components/NavItem.vue'
  import LinkBtn from '@/Components/LinkBtn.vue'
  import { getFacultyName } from '@/Components/Lectures/GetNameFromId.vue'

  const page = usePage()
  const user = computed(() => page.props.auth.user)

  const drawer = ref(false)
  const nav = ref(null)
</script>

<template>
    <v-app>

      <v-navigation-drawer v-model="drawer" color="secondary">

        <NavAvatar
          :name="user.name"
          :faculty="getFacultyName(page.props.share.faculties, user.faculty_id)"
          :grade="user.grade"
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
              :href="route('lecture.index')"
              title="講義一覧"
              :icon="mdiListBox"
              component="Lecture/Index"
            />
            <NavItem
              :href="route('lecture.create')"
              title="レビュー作成"
              :icon="mdiPenPlus"
              component="Lecture/Create"
            />
            <NavItem
              :href="route('lecture.create')"
              title="ランキング"
              :icon="mdiCrown"
              component="Lecture/Create"
            />
          </v-list-group>

          <NavItem :href="'/'" :icon="mdiChat" title="雑談部屋" />
          <NavItem :href="'/'" :icon="mdiChatQuestion" title="お問い合わせ" />

        </v-list>

        <template v-slot:append>
          <div class="pa-2"><LinkBtn :href="route('logout')" method="post">ログアウト</LinkBtn></div>
        </template>

      </v-navigation-drawer>

      <v-app-bar color="primary">

        <v-app-bar-nav-icon @click="drawer = !drawer" size="x-large" />
        <h1><v-app-bar-title class="text-h5">文教掲示板</v-app-bar-title></h1>

        <template v-slot:append>
          <Link :href="route('lecture.create')" class="me-3" color="secondary">
            <v-icon :icon="mdiPenPlus" />投稿
          </Link>
          <v-avatar color="grey-lighten-2" class="me-2">
            <v-menu activator="parent">
              <v-list>
                <v-list-item link title="プロフィール"></v-list-item>
                <v-list-item link title="アカウント情報"></v-list-item>
              </v-list>
            </v-menu>
          </v-avatar>
        </template>

      </v-app-bar>

      <v-main class="mx-auto" style="width: 100%;">
        <slot />
      </v-main>

    </v-app>

</template>