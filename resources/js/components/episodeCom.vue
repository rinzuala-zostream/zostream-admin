<template>
  <div
    class="form-container bg-white dark:bg-gray-950 text-gray-800 dark:text-gray-100 p-6 sm:p-8 md:p-10 rounded-xl shadow-2xl w-full">
    <h2 class="text-2xl sm:text-3xl font-bold mb-8 text-center sm:text-left text-gray-900 dark:text-white tracking-tight">
      Add New Episode
    </h2>

    <form @submit.prevent="submitForm" class="space-y-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
        <!-- Common Input Classes (applied to each input below) -->
        <!--
          block w-full rounded-lg border-0 py-2.5 px-3.5
          text-gray-900 dark:text-gray-100
          shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700
          placeholder:text-gray-400 dark:placeholder:text-gray-500
          focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500
          sm:text-sm sm:leading-6 bg-white dark:bg-gray-900
        -->

        <!-- Title -->
        <div class="form-group">
          <label for="title" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Episode Title</label>
          <input id="title" v-model="form.title" type="text"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="Enter episode title">
        </div>

        <!-- Description -->
        <div class="form-group sm:col-span-2 lg:col-span-3">
          <label for="desc" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Episode Description</label>
          <textarea id="desc" v-model="form.desc"
            class="block w-full min-h-[8rem] rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            rows="4" placeholder="Provide episode details..."></textarea>
        </div>

        <!-- Episode TXT -->
        <div class="form-group">
          <label for="txt" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Episode Identifier (e.g., S1 E1)</label>
          <input id="txt" v-model="form.txt" type="text"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="S1 E1">
        </div>

        <!-- Season ID -->
        <div class="form-group">
          <label for="season_id" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Season ID</label>
          <input id="season_id" v-model="form.season_id" type="text"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="Enter Season ID">
        </div>


        <!-- PPV Amount -->
        <div class="form-group">
          <label for="ppv_amount" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">PPV Rate</label>
          <input id="ppv_amount" v-model="form.ppv_amount" type="text"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="e.g., 200 or Free">
        </div>

        <!-- Cover Image -->
        <div class="form-group">
          <label for="img" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Cover Image URL</label>
          <input id="img" v-model="form.img" type="url"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="https://example.com/image.jpg">
        </div>

        <!-- URL -->
        <div class="form-group">
          <label for="url" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Video URL</label>
          <input id="url" v-model="form.url" type="url"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="https://example.com/episode.mp4">
        </div>

        <!-- DASH URL -->
        <div class="form-group">
          <label for="dash_url" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">DASH URL</label>
          <input id="dash_url" v-model="form.dash_url" type="url"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="https://example.com/episode.mpd">
        </div>

        <!-- HLS URL -->
        <div class="form-group">
          <label for="hls_url" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">HLS URL</label>
          <input id="hls_url" v-model="form.hls_url" type="url"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="https://example.com/episode.m3u8">
        </div>
      </div>

      <!-- Boolean Options -->
      <div class="attributes-section pt-8 border-t border-gray-200 dark:border-gray-800">
        <h3 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">Episode Attributes</h3>
        <div class="checkboxes-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-5">
          <label v-for="(label, key) in booleanFields" :key="key"
            class="checkbox-label flex items-center space-x-3 cursor-pointer group">
            <input type="checkbox" :id="`checkbox-${key}`" v-model="form[key]" class="sr-only peer">
            <span class="custom-checkbox w-5 h-5 rounded-md border flex items-center justify-center
                         border-gray-400 dark:border-gray-600 bg-white dark:bg-gray-800
                         group-hover:border-gray-500 dark:group-hover:border-gray-500
                         peer-checked:bg-blue-600 peer-checked:border-blue-600
                         dark:peer-checked:bg-blue-500 dark:peer-checked:border-blue-500
                         peer-focus-visible:ring-2 peer-focus-visible:ring-offset-2 peer-focus-visible:ring-blue-500 dark:peer-focus-visible:ring-offset-gray-950
                         transition-all duration-150 ease-in-out">
              <svg class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-150"
                fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"></path>
              </svg>
            </span>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 select-none group-hover:text-gray-900 dark:group-hover:text-white transition-colors">
              {{ label }}
            </span>
          </label>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="pt-8 flex justify-center">
        <button type="submit"
          class="submit-button w-full sm:w-auto py-3 px-8 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-950 disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-150 ease-in-out flex justify-center items-center"
          :disabled="loading">
          <span v-if="!loading">Submit Episode</span>
          <span v-else
            class="loading-spinner w-5 h-5 border-2 border-white/40 border-t-white rounded-full animate-spin"></span>
        </button>
      </div>


      <!-- Success/Error Message -->
      <div v-if="message" class="message mt-6 p-4 rounded-lg text-sm font-medium text-center" :class="{
        'bg-green-50 dark:bg-green-700/20 text-green-700 dark:text-green-300 border border-green-300 dark:border-green-600/50': !message.startsWith('Failed'),
        'bg-red-50 dark:bg-red-700/20 text-red-700 dark:text-red-300 border border-red-300 dark:border-red-600/50': message.startsWith('Failed')
      }">
        {{ message }}
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import axios from 'axios'

const getInitialFormState = () => ({
  title: '',
  desc: '',
  ppv_amount: '',
  season_id: '',
  txt: '',
  img: '',
  url: '',
  dash_url: '',
  hls_url: '',
  isProtected: false,
  isEnable: true,
  isPPV: false,
  isPremium: false,
})

const form = reactive(getInitialFormState())

const booleanFields = {
  isProtected: 'Protected',
  isEnable: 'Enable',
  isPPV: 'Pay Per View',
  isPremium: 'Premium',
}

const loading = ref(false)
const message = ref('')
const error = ref(null)

const validateForm = () => {
  if (!form.title.trim()) throw new Error('Episode title is required.')
  if (!form.desc.trim()) throw new Error('Episode description is required.')
  if (!form.season_id.trim()) throw new Error('Season ID is required.')
  if (!form.txt.trim()) throw new Error('Episode TXT is required.')
}

const encryptViaProxy = async (plainUrl) => {
  try {
    const res = await axios.get(route('proxy.get'), {
      params: {
        endpoint: 'encrypt',
        message: plainUrl
      }
    })
    return res.data.encrypted || ''
  } catch (e) {
    console.warn('Encryption failed:', e)
    return ''
  }
}

const submitForm = async () => {
  loading.value = true
  message.value = ''
  error.value = null

  try {
    validateForm()

    const [encryptedUrl, encryptedDash, encryptedHls] = await Promise.all([
      form.url ? encryptViaProxy(form.url) : '',
      form.dash_url ? encryptViaProxy(form.dash_url) : '',
      form.hls_url ? encryptViaProxy(form.hls_url) : ''
    ])

    form.url = encryptedUrl
    form.dash_url = encryptedDash
    form.hls_url = encryptedHls

    const payload = Object.fromEntries(
      Object.entries(form).filter(([_, value]) =>
        value !== '' || typeof value === 'boolean' || typeof value === 'number'
      )
    )

    console.log(payload);

    await axios.post(route('proxy.post'), payload, {
      params: { endpoint: 'episode-insert' },
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })

    message.value = 'Episode added successfully!'
    const preservedToken = form.token
    Object.assign(form, getInitialFormState())
    form.token = preservedToken
  } catch (err) {
    if (err.response) {
      error.value = err.response.data?.message || err.response.data?.error || 'Server error'
    } else if (err.request) {
      error.value = 'No response from server.'
    } else {
      error.value = err.message
    }
    message.value = `Failed: ${error.value}`
  } finally {
    loading.value = false
  }
}

defineExpose({ submitForm })
</script>
