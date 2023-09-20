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
      <slot /><span style="color: red">*</span>
    </template>
  </v-text-field>
</template>