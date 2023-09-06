<script setup>
  import { ref } from 'vue'
  import NavAvatar from '@/Components/NavAvatar.vue';
  import NavItem from '@/Components/NavItem.vue';
  import { Link } from '@inertiajs/vue3';

  const drawer = ref(false)
  const links = [
        { text: '講義', icon: 'mdi-account-school', href: "/lectures" },
        { text: 'グルメ', icon: 'mdi-silverware-fork-knife', href: "/lectures/create"},
        { text: '教科書', icon: 'mdi-book-open-blank-variant' },
        { text: '雑談', icon: 'mdi-chat' }
  ]
</script>

<template>
    <v-app>

      <v-navigation-drawer v-model="drawer">
        <NavAvatar />
        
        <v-list nav>
          <NavItem
            v-for="(link, i) in links"
              :key="i"
              :value="item"
              :text="link.text"
              :icon="link.icon"
              :href="link.href"
          />
        </v-list>
      </v-navigation-drawer>

      <v-app-bar>
        <v-app-bar-nav-icon @click="drawer = !drawer" />
        <v-app-bar-title>文教掲示板</v-app-bar-title>
      </v-app-bar>

      <v-main class="bg-grey-lighten-2">
        <slot />
      </v-main>

    </v-app>

</template>