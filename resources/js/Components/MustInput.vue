<script setup>

</script>

<template>
  <v-text-field
    density="compact"
    variant="underlined"
    clearable
    persistent-hint
    persistent-counter
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
  </v-text-field>
</template>