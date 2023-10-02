<script setup>
  import { ref } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { mdiBookmarkOutline, mdiBookmarkCheck } from '@mdi/js'
  import { useToast } from "vue-toastification"

  const props = defineProps(['isBookmarked', 'lectureId', 'count'])

  const toast = useToast()
  const onProgress = ref(false)

  const setBookmark = () => {
    router.put(route('bookmark.set', props.lectureId), {}, {
      preserveScroll: true,
      onBefore: () => { onProgress.value = true },
      onSuccess: () => { toast.success('ブックマークが登録されました。'), onProgress.value = false },
    })
  }

  const removeBookmark = () => {
    router.delete(route('bookmark.remove', props.lectureId), {
      preserveScroll: true,
      onBefore: () => { onProgress.value = true },
      onSuccess: () => { toast.success('ブックマークが解除されました。'), onProgress.value = false },
    })
  }
</script>

<template>
  <button
    @click="props.isBookmarked
      ? [removeBookmark(), count--, isBookmarked = !isBookmarked]
      : [setBookmark(), count++, isBookmarked = !isBookmarked]"
    :disabled="onProgress"
    style="color: #26A69A;"
  >
    <v-icon
      :icon="props.isBookmarked ? mdiBookmarkCheck : mdiBookmarkOutline"
    />
    <span>{{ count }}</span>
  </button>
</template>