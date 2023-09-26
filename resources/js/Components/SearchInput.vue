<script setup>
  defineProps(['items', 'icon'])
</script>

<template>
  <v-combobox
    :items="items"
    :prepend-inner-icon="icon"
    clearable
    multiple
    chips
    closable-chips
    persistent-hint
    hide-selected
    hint="検索候補クリック・Enter・完了で確定します"
    variant="solo"
    density="compact"
    rounded="xl"
    menu-icon=""
    auto-select-first="exact"
  />
</template>