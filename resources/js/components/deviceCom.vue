<template>
  <div class="max-w-md mx-auto p-6">
    <h1 class="text-2xl font-semibold text-center mb-6">Clear Device</h1>

    <div class="flex gap-3 mb-4">
      <input
        v-model="uid"
        type="text"
        placeholder="Enter UID"
        class="flex-1 px-4 py-2 border rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
      <button
        @click="clearDevice"
        :disabled="!uid || loading"
        class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 disabled:opacity-50"
      >
        Clear Device
      </button>
    </div>

    <div class="flex justify-center mb-6">
      <button
        @click="insertUidFromCache"
        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-sm rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600"
      >
        Insert UID from Cache
      </button>
    </div>

    <div v-if="loading" class="text-center text-gray-500">Processing...</div>
    <div v-if="message" :class="`text-center font-medium ${error ? 'text-red-600' : 'text-green-600'}`">
      {{ message }}
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const uid = ref('')
const loading = ref(false)
const message = ref('')
const error = ref(false)

const clearDevice = async () => {
  loading.value = true
  message.value = ''
  error.value = false

  try {
    await axios.post(route('proxy.post'), { user_id: uid.value }, {
      params: {
        endpoint: 'clear-device',
      },
    })

    message.value = 'Device cleared successfully.'
  } catch (err) {
    error.value = true
    message.value = err.response?.data?.message || 'Failed to clear device.'
  } finally {
    loading.value = false
  }
}

const insertUidFromCache = () => {
  const cachedUid = sessionStorage.getItem('searchedUserUid')
  if (cachedUid) {
    uid.value = cachedUid
  } else {
    message.value = 'No cached UID found.'
    error.value = true
  }
}
</script>
