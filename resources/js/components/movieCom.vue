<template>
  <div
    class="form-container bg-white dark:bg-gray-950 text-gray-800 dark:text-gray-100 p-6 sm:p-8 md:p-10 rounded-xl shadow-2xl w-full">
    <h2
      class="text-2xl sm:text-3xl font-bold mb-8 text-center sm:text-left text-gray-900 dark:text-white tracking-tight">
      Add New Movie
    </h2>

    <form @submit.prevent="submitForm" class="space-y-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
        <!-- Common Input Classes -->
        <!--
          Base input style:
          block w-full rounded-lg border-0 py-2.5 px-3.5
          text-gray-900 dark:text-gray-100
          shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700
          placeholder:text-gray-400 dark:placeholder:text-gray-500
          focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500
          sm:text-sm sm:leading-6 bg-white dark:bg-gray-900
        -->

        <!-- Title -->
        <div class="form-group sm:col-span-2 lg:col-span-3">
          <label for="title" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Episode
            Title</label>
          <input id="title" v-model="form.title" type="text"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="Enter movie title">
        </div>

        <!-- Description -->
        <div class="form-group sm:col-span-2 lg:col-span-3">
          <label for="description"
            class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Description</label>
          <textarea id="description" v-model="form.description"
            class="block w-full min-h-[8rem] rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            rows="4" placeholder="Provide a compelling movie description..."></textarea>
        </div>

        <div class="form-group sm:col-span-2 lg:col-span-3">
          <label for="token"
            class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Token</label>
          <textarea id="token" v-model="form.token"
            class="block w-full min-h-[8rem] rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            rows="4" placeholder="Provide movie token..."></textarea>
        </div>

        <!-- Genre -->
        <div class="form-group">
          <label for="genre"
            class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Genre</label>
          <input id="genre" v-model="form.genre" type="text"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="e.g., Action, Comedy">
        </div>

        <!-- Director -->
        <div class="form-group">
          <label for="director"
            class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Director</label>
          <input id="director" v-model="form.director" type="text"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="Director's Name">
        </div>

        <!-- Duration -->
        <div class="form-group">
          <label for="duration"
            class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Duration</label>
          <input id="duration" v-model="form.duration" type="text"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="e.g., 2h 30m">
        </div>

        <div class="form-group">
          <label for="ppv_amount"
            class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">PPV rate</label>
          <input id="ppv_amount" v-model="form.ppv_amount" type="text"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="e.g., 200 or Free">
        </div>

        <div class="form-group">
          <label for="status" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">
            Status
          </label>
          <select id="status" v-model="form.status"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900">
            <option disabled value="">Select status</option>
            <option value="Scheduled">Scheduled</option>
            <option value="Published">Published</option>
            <option value="Draft">Draft</option>
          </select>
        </div>

        <div class="form-group">
          <label for="upload_date"
            class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Create Date</label>
          <input id="upload_date" v-model="form.create_date" type="date"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900">
        </div>

        <!-- Poster URL -->
        <div class="form-group">
          <label for="poster" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Poster
            URL</label>
          <input id="poster" v-model="form.poster" type="url"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="https://example.com/poster.jpg">
        </div>

        <!-- Cover Image URL -->
        <div class="form-group">
          <label for="cover_img"
            class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Cover Image URL</label>
          <input id="cover_img" v-model="form.cover_img" type="url"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="https://example.com/cover.jpg">
        </div>

        <!-- Release Date -->
        <div class="form-group">
          <label for="release_on"
            class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Movie Release
            Date</label>
          <input id="release_on" v-model="form.release_on" type="date"
            class="block w-full rounded-lg border-0 py-2 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900 dark:[color-scheme:dark]">
          <!-- Added dark:[color-scheme:dark] for better date picker in dark mode -->
        </div>

        <!-- Movie URL -->
        <div class="form-group">
          <label for="url" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Movie
            URL</label>
          <input id="url" v-model="form.url" type="url"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="https://example.com/movie.mp4">
        </div>

        <!-- Dash URL -->
        <div class="form-group">
          <label for="dash_url" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Dash
            URL</label>
          <input id="dash_url" v-model="form.dash_url" type="url"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="https://example.com/movie.mpd">
        </div>

        <!-- HLS URL -->
        <div class="form-group">
          <label for="hls_url" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">HLS
            URL</label>
          <input id="hls_url" v-model="form.hls_url" type="url"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="https://example.com/movie.m3u8">
        </div>
      </div>

      <!-- Boolean Fields -->
      <div class="attributes-section pt-8 border-t border-gray-200 dark:border-gray-800">
        <h3 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">Movie Attributes</h3>
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
            <span
              class="text-sm font-medium text-gray-700 dark:text-gray-300 select-none group-hover:text-gray-900 dark:group-hover:text-white transition-colors">
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
          <span v-if="!loading">Submit Movie</span>
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
  title: '', genre: '', director: '', duration: '', description: '', ppv_amount: '',
  poster: '', cover_img: '', url: '', dash_url: '', hls_url: '', trailer: '',
  release_on: '', create_date: '', status: '',
  isProtected: false, isBollywood: false, isCompleted: false, isDocumentary: false,
  isAgeRestricted: false, isDubbed: false, isEnable: true, isHollywood: false,
  isKorean: false, isMizo: false, isPayPerView: false, isPremium: false,
  isSeason: false, isSubtitle: false,
  views: 0, token: ''
})

const form = reactive(getInitialFormState())

const booleanFields = reactive({
  isProtected: 'Protected', isBollywood: 'Bollywood', isCompleted: 'Completed',
  isDocumentary: 'Documentary', isAgeRestricted: 'Age Restricted', isDubbed: 'Dubbed',
  isEnable: 'Enable', isHollywood: 'Hollywood', isKorean: 'Korean', isMizo: 'Mizo',
  isPayPerView: 'Pay Per View', isPremium: 'Premium', isSeason: 'Season',
  isSubtitle: 'Has Subtitle'
})

const loading = ref(false)
const message = ref('')
const error = ref(null)

// Validate form fields
const validateForm = () => {
  if (!form.title.trim()) throw new Error('Title is required')
  if (!form.genre.trim()) throw new Error('Genre is required')
  if (!form.poster.trim()) throw new Error('Poster URL is required')
  if (!form.release_on) throw new Error('Release date is required')
}

// Encrypt via proxy using "message" parameter
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
    console.warn(`Encryption failed for: ${plainUrl}`, e)
    return ''
  }
}

const submitForm = async () => {
  loading.value = true
  message.value = ''
  error.value = null

  try {
    validateForm()

    // Encrypt all URL fields separately
    const [encryptedUrl, encryptedDash, encryptedHls] = await Promise.all([
      form.url ? encryptViaProxy(form.url) : '',
      form.dash_url ? encryptViaProxy(form.dash_url) : '',
      form.hls_url ? encryptViaProxy(form.hls_url) : ''
    ])

    // Assign encrypted values
    form.url = encryptedUrl
    form.dash_url = encryptedDash
    form.hls_url = encryptedHls

    // Prepare final payload
    const payload = Object.fromEntries(
      Object.entries(form).filter(([_, value]) =>
        value !== '' || typeof value === 'boolean' || typeof value === 'number'
      )
    )

    await axios.post(route('proxy.post'), payload, {
      params: { endpoint: 'insert' },
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })

    message.value = 'Movie added successfully!'
    const currentToken = form.token
    Object.assign(form, getInitialFormState())
    form.token = currentToken

  } catch (err) {
    if (err.response) {
      error.value = err.response.data?.message || err.response.data?.error || 'Server error'
      console.error('Server response:', err.response.data)
    } else if (err.request) {
      error.value = 'No response from server.'
    } else {
      error.value = err.message
    }
    message.value = error.value
  } finally {
    loading.value = false
  }
}

defineExpose({ submitForm })
</script>
