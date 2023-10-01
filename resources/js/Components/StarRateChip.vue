<script setup>
  defineProps(['label', 'star', 'small'])
</script>

<template>
  <v-chip
    label
    color="primary"
    :class="[ (small) ? 'px-1 text-caption' : 'px-2 text-body-2' ]"
    :style="{ height: [ (small) ? '20px' : '30px' ] }"
  >
    {{ label }}
  </v-chip>

  <span
    :class="[ (small) ? 'text-body-2 mx-n1' : 'text-subtitle-1 mx-n1' ]"
    style="color: #26A69A;"
  >
    ★
  </span>
  <span
    :class="[ (small) ? 'text-caption' : 'text-subtitle-2 text-medium-emphasis' ]">
    {{ star }}
  </span>
</template>