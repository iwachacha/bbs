<script setup>
  import { ref, computed } from 'vue'
  import { mdiAccountCircle } from '@mdi/js'
  import DotMenuBtn from '@/Components/DotMenuBtn.vue'

  defineProps(['barTitle', 'icon', 'cardTitle', 'readMore'])

  const open = ref(false)
  const readMoreBtn = computed(() => {
    return open.value ? '閉じる' : '続きを読む'
  })

</script>

<template>
  <v-card rounded="sm">

    <v-toolbar density="compact" color="teal-lighten-2">
      <v-icon v-if="icon" :icon="mdiAccountCircle" color="secondary" size="large" class="ms-2 me-n2" />
      <v-toolbar-title class="text-subtitle-2">{{ barTitle }}</v-toolbar-title>
      <DotMenuBtn>
          <slot name="menuItem" />
      </DotMenuBtn>
    </v-toolbar>

    <v-card-title class="mt-2 pb-1 text-body-2 text-center">
      {{ cardTitle }}
    </v-card-title>

    <v-card-subtitle class="ms-3 text-caption text-right">
      <slot name="subtitle" />
    </v-card-subtitle>

    <v-card-text class="text-center mt-1">
      <slot name="text" />
    </v-card-text>

    <template v-if="readMore">
      <div :class="open ? 'text-right me-1 mt-n4 mb-n4' : 'text-right me-1 mb-2 mt-n4'">
        <v-btn
          @click="open = !open"
          variant="text"
          color="primary"
        >
          {{ readMoreBtn }}
        </v-btn>
      </div>
      <v-card-text v-if="open" class="pt-0">
        <slot name="readMoreContent" />
      </v-card-text>
    </template>

    <v-divider class="border-opacity-100" />

    <v-card-actions class="py-0 my-n1">
      <slot name="action" />
    </v-card-actions>

  </v-card>
</template>