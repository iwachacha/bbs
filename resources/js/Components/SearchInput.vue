<script setup>
  import { mdiMagnify } from '@mdi/js'

  defineProps(['items'])
</script>

<template>
  <v-combobox
    :items="items"
    :prepend-inner-icon="mdiMagnify"
    clearable
    multiple
    chips
    closable-chips
    persistent-hint
    hide-selected
    hide-details
    placeholder="検索ワードを入力してください"
    variant="solo"
    density="compact"
    rounded="xl"
    menu-icon=""
    auto-select-first="exact"
  />
</template>