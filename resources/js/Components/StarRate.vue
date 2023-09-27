<script setup>
  defineProps(['title', 'average', 'totalCount', 'valueCounts', ])
</script>

<template>
  <div class="text-center text-h6 text-medium-emphasis">
    {{ title }}
  </div>

  <div class="d-flex align-center flex-column text-medium-emphasis">
    <div class="text-h6 mt-2">
      {{ average }}
      <span class="text-subtitle-2 text-medium-emphasis">/ 5</span>
    </div>

    <v-rating
      :model-value="average"
      color="primary"
      size="35"
      half-increments
      readonly
    />
  </div>

  <v-list
    bg-color="transparent"
    class="d-flex flex-column-reverse text-medium-emphasis"
    density="compact"
  >

    <v-list-item v-for="(valueCount, i) in valueCounts" class="pa-0">
      <v-row justify="center">

        <v-col cols="1" class="px-0 text-right">
          <span class="text-body-1" style="color: #26A69A;">★</span>{{ i+1 }}
        </v-col>

        <v-col cols="9" class="px-3">
          <v-progress-linear
            :model-value="valueCount / totalCount * 100"
            color="#4DB6AC"
            height="15"
            rounded
          />
        </v-col>

        <v-col cols="1" class="px-0 text-left">
          <span>{{ valueCount }}</span>
        </v-col>

      </v-row>
    </v-list-item>
  </v-list>
</template>