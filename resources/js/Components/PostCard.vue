<script setup>
  import { ref, computed } from 'vue'
  import DotMenuBtn from '@/Components/DotMenuBtn.vue'

  defineProps(['readMore'])

  const open = ref(false)
  const readMoreBtnText = computed(() => {
    return open.value ? '閉じる' : '続きを読む'
  })

</script>

<template>
  <v-card rounded="sm">

    <v-toolbar density="compact" color="teal-lighten-2">
      <v-toolbar-title class="text-subtitle-2 text-sm-subtitle-1">
        <h3><slot name="barTitle" /></h3>
      </v-toolbar-title>

      <DotMenuBtn v-if="$page.props.auth.user">
          <slot name="menuItem" />
      </DotMenuBtn>
    </v-toolbar>

    <v-card-title class="mt-3 pb-1 text-body-2 text-sm-body-1 text-center" style="line-height: normal;">
      <slot name="cardTitle" />
    </v-card-title>

    <v-card-subtitle class="text-caption text-right">
      <slot name="subtitle" />
    </v-card-subtitle>

    <v-card-text class="text-center py-2">
      <slot name="text" />
    </v-card-text>

    <template v-if="readMore">
      <div :class="open ? 'text-right me-1 mb-n4' : 'text-right me-1 mb-1'">
        <v-btn
          @click="open = !open"
          variant="text"
          color="primary"
        >
          {{ readMoreBtnText }}
        </v-btn>
      </div>
      <v-card-text v-if="open">
        <slot name="readMoreContent" />
      </v-card-text>
    </template>

    <v-divider class="border-opacity-100" />

    <v-card-actions class="px-2 py-0 my-n1">
      <slot name="action" />
    </v-card-actions>

  </v-card>
</template>