<script setup>
  import { useForm } from '@inertiajs/vue3';

  defineProps({
    errors: Object
  })

  const form = useForm({
    title: null,
    comment: null,
  })
</script>

<script>
  import Layout from '@/Pages/Dashboard.vue';

  export default {
    layout: Layout,
  }
</script>

<template>
    <v-sheet class="bg-deep-purple pa-12" rounded>
      <v-card class="mx-auto px-6 py-8" max-width="344">
        <v-form @submit.prevent="form.post('/lectures')">

          <v-text-field
            v-model="form.title"
            class="mb-2"
            clearable
            counter="5"
            persistent-hint
            variant="solo"
            label="タイトル"
            placeholder="タイトルを入力してください"
            hint="タイトルです"
          ></v-text-field>

          <v-text-field
            v-model="form.comment"
            clearable
            persistent-hint
            variant="solo"
            label="コメント"
            placeholder="コメントを入力してください"
            hint="コメントです"
          ></v-text-field>

          <br>

          <v-btn
            block
            color="success"
            size="large"
            type="submit"
            variant="elevated"
          >
            送信
          </v-btn>
        </v-form>
      </v-card>
    </v-sheet>
</template>