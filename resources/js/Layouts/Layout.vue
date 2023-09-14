<script setup>
  import { ref, computed } from 'vue'
  import { mdiAccountSchool, mdiSilverwareForkKnife, mdiBookOpenBlankVariant, mdiChat } from '@mdi/js'
  import { usePage, } from '@inertiajs/vue3'
  import NavAvatar from '@/Components/NavAvatar.vue';
  import NavItem from '@/Components/NavItem.vue';
  import LinkBtn from '@/Components/LinkBtn.vue';

  const page = usePage()
  const user = computed(() => page.props.auth.user)

  const drawer = ref(false)
</script>

<template>
    <v-app>

      <v-navigation-drawer v-model="drawer">

        <NavAvatar :name="user.name"/>

        <v-list nav>
          <NavItem :href="'/lectures'" :icon="mdiAccountSchool">講義評価</NavItem>
          <NavItem :href="'/lectures/create'" :icon="mdiSilverwareForkKnife">グルメ</NavItem>
          <NavItem :href="'/'" :icon="mdiBookOpenBlankVariant">教科書</NavItem>
          <NavItem :href="'/'" :icon="mdiChat">雑談</NavItem>
        </v-list>

        <template v-slot:append>
          <LinkBtn :href="route('logout')" method="post">ログアウト</LinkBtn>
        </template>

      </v-navigation-drawer>

      <v-app-bar density="compact">
        <v-app-bar-nav-icon @click="drawer = !drawer" />
        <v-app-bar-title>文教掲示板</v-app-bar-title>
      </v-app-bar>

      <v-main class="mx-auto" style="width: 95%;">
        <slot />
      </v-main>

    </v-app>

</template>