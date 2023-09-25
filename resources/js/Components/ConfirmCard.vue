<script setup>
  defineProps(['title', 'subtitle', 'text', 'items', 'dialog'])
</script>

<template>
  <v-dialog
    :modelValue="dialog"
    @update:modelValue="dialog = $event"
    maxWidth="700px"
    persistent
  >

    <v-card>

      <v-toolbar
        color="primary"
        :title="title"
      />

      <v-card-title v-if="subtitle" class="text-medium-emphasis mt-3" style="white-space: normal; line-height: normal;">
        {{ subtitle }}
      </v-card-title>

      <v-card-subtitle v-if="text" class="text-high-emphasis ms-3 mb-3" style="white-space: normal; line-height: normal;">
        {{ text }}
      </v-card-subtitle>

      <v-card-text max-height="300" class="overflow-y-auto mx-3">
        <v-row justify="center" align="center" class="text-center my-2">
          <template v-for="item in items">
            <v-col cols="12" sm="4" class="text-left text-sm-center font-weight-bold py-2 px-0">{{ item.key }}</v-col>
            <v-col cols="1" sm="1" class="d-none d-sm-block py-2 px-0"></v-col>
            <v-col cols="12" sm="7" class="py-2 px-0">{{ item.value}}</v-col>
            <v-divider class="border-opacity-100" />
          </template>
        </v-row>

        <slot />
      </v-card-text>

      <v-divider class="border-opacity-100" />

      <v-card-actions>
        <slot name="cancelBtn" />
        <v-spacer />
        <slot name="okBtn" />
      </v-card-actions>
    </v-card>

  </v-dialog>
</template>