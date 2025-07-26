<!-- resources/js/components/PlayerLauncher.vue -->
<template>
    <div class="p-8 text-center">
      <h1 class="text-2xl font-bold mb-4">Play with Shaka Player</h1>
      <input
        v-model="videoUrl"
        type="text"
        placeholder="Enter video .mpd or .m3u8 URL"
        class="border border-gray-400 p-2 rounded w-3/4 mb-4"
      />
      <br />
      <button
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        @click="showPlayer = true"
        :disabled="!videoUrl"
      >
        ▶ Play
      </button>

      <ShakaPlayer v-if="showPlayer" :videoUrl="videoUrl" @close="showPlayer = false" />
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'
  import ShakaPlayer from '@/components/shakaPlayerCom.vue'

  const videoUrl = ref('')
  const showPlayer = ref(false)
  </script>
