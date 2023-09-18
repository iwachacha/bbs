<script setup>

</script>

<template>
  <v-select
    clearable
    density="compact"
    variant="underlined"
    persistent-hint
    class="mb-5"
  >
    <template v-slot:label>
      <slot /><span style="color: red">*</span>
    </template>
  </v-select>
</template>
