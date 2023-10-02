<script setup>
  import { ref, watch } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification"

  const props = defineProps(['reviewId'])

  const onProgress = ref(false)
  const goodCount = ref(0)

  //それなボタンを押してから5秒後にまとめてクリック回数を送信
  watch(goodCount, () => {
    if(goodCount.value === 1){
      useToast().info('5秒後にそれな！の回数をまとめて送信します。')

      window.setTimeout(() => {
        router.post(route('review.good', props.reviewId), {
          count: goodCount.value
        }, {
          preserveScroll: true,
          onBefore: () => { onProgress.value = true },
          onSuccess: () => {
            [useToast().success(goodCount.value + '回のそれな！が登録されました。'), goodCount.value = 0, onProgress.value = false]
          },
          only: ['reviews', 'query']
        })
      }, 5000);
    }
  })
</script>

<template>
  <button
    @click="goodCount++"
    :disabled="onProgress"
    style="color: #26A69A;"
    class="text-button"
  >
    <span>{{ goodCount ? goodCount : '' }}</span>
    それな！
  </button>
</template>