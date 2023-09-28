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
        <slot name="barTitle" />
      </v-toolbar-title>

      <DotMenuBtn>
          <slot name="menuItem" />
      </DotMenuBtn>
    </v-toolbar>

    <v-card-title class="mt-3 pb-1 text-body-1 text-center" style="line-height: normal;">
      <slot name="cardTitle" />
    </v-card-title>

    <v-card-subtitle class="text-caption text-right">
      <slot name="subtitle" />
    </v-card-subtitle>

    <v-card-text class="text-center mt-1">
      <slot name="text" />
    </v-card-text>

    <template v-if="readMore">
      <div :class="open ? 'text-right me-1 mt-n2 mb-n4' : 'text-right me-1 mb-2 mt-n2'">
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