<script setup>

</script>

<template>
  <v-select
    clearable
    density="compact"
    variant="underlined"
    persistent-hint
    class="mb-3"
  >
    <template v-slot:label>
      <slot />
      <v-chip
        class="px-1"
        color="#FF5252"
        size="x-small"
      >
        必須
      </v-chip>
    </template>
  </v-select>
</template>
