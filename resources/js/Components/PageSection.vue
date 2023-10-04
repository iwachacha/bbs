<script setup>
  import LinkBtn from '@/Components/LinkBtn.vue'

  defineProps(['icon', 'title', 'subtitle', 'mustAuth', 'guestViewing'])
</script>

<template>
  <v-sheet rounded="0" color="secondary" class="mb-16 mx-auto">

    <v-card-title
      class="ps-0 pe-10 mt-7 text-h6 text-sm-h5 text-medium-emphasis d-flex align-center justify-center"
      style="white-space: normal; line-height: normal;"
    >
      <v-icon :icon="icon" class="me-2" size="32" />
      <h2>{{ title }}</h2>
    </v-card-title>

    <v-card-subtitle v-if="subtitle" class="px-0 pb-2 text-center text-caption" style="white-space: pre-wrap;">
      {{ subtitle }}
    </v-card-subtitle>

    <template v-if="guestViewing"> <!-- ゲスト閲覧可能ならそのままコンテンツを表示 -->
      <div class="mt-5 px-3 px-md-10 py-0" >
        <slot />
      </div>
    </template>

    <template v-else> <!-- ゲスト閲覧不可能かつ未ログイン状態ならコンテンツにぼかしを入れ、ログインボタン表示 -->
      <LinkBtn
        v-if="!$page.props.auth.user"
        :href="route('login')"
        class="login_btn"
        >
          <span class="pa-2">ログインして閲覧する</span>
      </LinkBtn>

      <div class="mt-5 px-3 px-md-10 py-0" :class="{guest : !$page.props.auth.user}">
        <slot />
      </div>
    </template>
  </v-sheet>
</template>

<style>
  .guest {
    -webkit-filter:blur(5px);
    -moz-filter:blur(5px);
    -ms-filter: blur(5px);
    filter: blur(5px);
    opacity: 0.7;
  }

  .login_btn {
    position: fixed;
    bottom: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1;
  }
</style>