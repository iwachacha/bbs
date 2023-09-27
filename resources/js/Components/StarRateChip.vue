<script setup>
  defineProps(['label', 'star', 'small'])
</script>

<template>
  <v-chip
    label
    color="primary"
    :class="[ (small) ? 'px-1 text-caption' : 'px-2 text-sm-body-1 text-body-2' ]"
    :style="{ height: [ (small) ? '18px' : '30px' ] }"
  >
    {{ label }}
  </v-chip>

  <span
    :class="[ (small) ? 'text-body-2' : 'text-subtitle-1' ]"
    style="color: #26A69A;"
  >
    ★
  </span>
  <span
    :class="[ (small) ? 'text-caption' : 'text-subtitle-2' ]">
    {{ star }}
  </span>
</template>