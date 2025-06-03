<template>
  <div
    class="form-container bg-white dark:bg-gray-950 text-gray-800 dark:text-gray-100 p-6 sm:p-8 md:p-10 rounded-xl shadow-2xl w-full">
    <h2 class="text-2xl sm:text-3xl font-bold mb-8 text-center sm:text-left text-gray-900 dark:text-white tracking-tight">
      Add New Episode
    </h2>

    <form @submit.prevent="submitForm" class="space-y-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
        <!-- Common Input Classes are applied individually below -->

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
        
        <div class="form-group sm:col-span-2 lg:col-span-3">
          <label for="token" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Token</label>
          <textarea id="token" v-model="form.token"
            class="block w-full min-h-[8rem] rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            rows="4" placeholder="Provide episode token..."></textarea>
        </div>

        <!-- Episode TXT -->
        <div class="form-group">
          <label for="txt" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Episode Identifier (e.g., S1 E1)</label>
          <input id="txt" v-model="form.txt" type="text"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="S1 E1">
        </div>

        <!-- Season ID (will be populated by search or manually) -->
        <div class="form-group">
          <label for="season_id" class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Season ID</label>
          <input id="season_id" v-model="form.season_id" type="text"
            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
            placeholder="Enter Season ID or search below">
        </div>
        <!-- movie_id is not rendered as an input -->

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
      </div> <!-- End of main input grid -->

      <div class="form-group"> <!-- Status dropdown -->
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

      <div class="form-group"> <!-- Create Date input -->
        <label for="create_date"
          class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Create Date</label>
        <input id="create_date" v-model="form.create_date" type="date"
          class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900">
      </div>

      <!-- Search Section for Show/Season -->
      <div class="search-section-container pt-8 border-t border-gray-200 dark:border-gray-800">
        <h3 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">Associate with Show/Season (for Season ID & Movie ID)</h3>
        
        <div v-if="selectedItemInfoText" class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg text-sm text-blue-700 dark:text-blue-300 flex justify-between items-center">
          <span>{{ selectedItemInfoText }}</span>
          <button @click="clearSelectedItem" type="button" class="ml-2 text-xs font-semibold text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 p-1 rounded hover:bg-blue-100 dark:hover:bg-blue-800/50 transition-colors">
            (Clear Selection)
          </button>
        </div>
        
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row gap-4 mb-3">
                <div class="relative flex-grow">
                    <input 
                        type="text" 
                        v-model="search" 
                        placeholder="Search by title to find Show/Season..." 
                        @keyup.enter="performSearch"
                        class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                    />
                </div>
            </div>
            <div class="flex justify-center sm:justify-start">
                <button
                    @click="performSearch"
                    :disabled="searchLoading" 
                    type="button"
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed w-full sm:w-auto"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <span>Search Show/Season</span>
                </button>
            </div>
        </div>

        <div v-if="searchLoading" class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-blue-500"></div>
        </div>

        <div v-if="!searchLoading">
          <div v-if="hasSearchedAtLeastOnce && movies.length === 0 && search.trim() !== ''" class="text-center py-4 text-gray-500 dark:text-gray-400">
            No items found matching: "{{ search }}".
          </div>
          <ul v-if="movies.length > 0" class="space-y-2 max-h-72 overflow-y-auto mt-4 border border-gray-200 dark:border-gray-700 rounded-lg p-2 bg-gray-50 dark:bg-gray-900/50 custom-scrollbar">
            <li v-for="movie in filteredMovies" :key="movie.id" 
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden border border-gray-200 dark:border-gray-700 group">
                <div class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" @click="selectMovie(movie)">
                    <div class="flex items-center space-x-3 min-w-0">
                        <div class="w-10 h-10 flex-shrink-0 rounded-lg bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                        </div>
                        <span class="font-medium truncate text-gray-800 dark:text-gray-100">{{ movie.title }} (Num: {{ movie.num }})</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                    </svg>
                </div>
            </li>
          </ul>
        </div>
      </div>
      <!-- End Search Section -->


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
          :disabled="formSubmitting">
          <span v-if="!formSubmitting">Submit Episode</span>
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
import { ref, reactive, computed, onMounted } from 'vue'
import axios from 'axios'

// Assuming route() is globally available (e.g., from Ziggy in Laravel)
// declare function route(name: string, params?: any): string;

const getInitialFormState = () => ({
  title: '',
  desc: '',
  ppv_amount: '',
  season_id: '', 
  movie_id: '', // To store movie.num, no direct input field
  txt: '',
  img: '',
  url: '',
  dash_url: '',
  hls_url: '',
  create_date: '', 
  status: '', 
  token: '',
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

const formSubmitting = ref(false) // Loading state for form submission
const message = ref('')
const error = ref(null)

// --- Search related reactive state ---
const search = ref('');
const movies = ref([]); 
const searchLoading = ref(false); // Specific loading state for search
const hasSearchedAtLeastOnce = ref(false);
const selectedItemInfoText = ref(''); // Renamed from selectedSeasonInfoText for clarity
const sortOrder = ref('asc'); 
// const showEditModal = ref(false); // Not used in this refined version directly, can be removed if not needed elsewhere

const validateForm = () => {
  if (!form.title.trim()) throw new Error('Episode title is required.')
  if (!form.season_id.toString().trim()) throw new Error('Season ID is required. Please search and select a show/season, or enter manually.')
  if (!form.movie_id.toString().trim()) throw new Error('Movie ID is required. Please search and select a show/season to populate it.') // Added validation for movie_id
  if (!form.txt.trim()) throw new Error('Episode Identifier (e.g., S1 E1) is required.')
}

const fetchMovies = async (query = '') => {
  searchLoading.value = true;
  movies.value = [];
  try {
    // Ensure your proxy.get route is correctly defined and working
    const response = await axios.get(route('proxy.get'), { 
      params: { endpoint:'search', q: query, age_restriction: true, is_enable: true }
    });
    // Adjust based on your API response structure for movie list
    // Assuming response.data is the array or response.data.data is the array
    const results = Array.isArray(response.data) 
      ? response.data 
      : (response.data?.data && Array.isArray(response.data.data) ? response.data.data : []);
    
    // Ensure each movie item has 'id' and 'num' properties
    movies.value = results.filter(movie => movie && typeof movie.id !== 'undefined' && typeof movie.num !== 'undefined');
    if (results.length !== movies.value.length) {
      console.warn("Some movie results were filtered out due to missing 'id' or 'num' properties.");
    }

  } catch (fetchError) {
    console.error('Failed to fetch movies:', fetchError);
    movies.value = []; 
    message.value = `Search failed: ${fetchError.message || 'Network error'}`; // Show error to user
  } finally {
    searchLoading.value = false;
  }
};

const performSearch = async () => {
  if (!search.value.trim()) {
    movies.value = [];
    hasSearchedAtLeastOnce.value = false;
    return;
  }
  hasSearchedAtLeastOnce.value = true;
  await fetchMovies(search.value.trim());
};

onMounted(() => { 
  const today = new Date().toISOString().split('T')[0];
  form.create_date = today;
});

const filteredMovies = computed(() => {
  if (!Array.isArray(movies.value)) return [];
  const moviesToSort = [...movies.value];
  moviesToSort.sort((a, b) => {
    const titleA = String(a.title || '').toLowerCase();
    const titleB = String(b.title || '').toLowerCase();
    return sortOrder.value === 'asc' ? titleA.localeCompare(titleB) : titleB.localeCompare(titleA);
  });
  return moviesToSort;
});

const selectMovie = (movie) => {
  if (!movie || typeof movie.num === 'undefined') {
    console.error('Selected movie item is invalid or missing id/num:', movie);
    message.value = "Error: Selected item is invalid.";
    return;
  }
  form.movie_id = movie.num;   // movie_id comes from item.num
  
  selectedItemInfoText.value = `Associated with: ${movie.title} (Movie/Show Num: ${movie.num})`;
  
  movies.value = []; 
  hasSearchedAtLeastOnce.value = false; 
};

const clearSelectedItem = () => {
  form.season_id = ''; 
  form.movie_id = '';
  selectedItemInfoText.value = '';
};

const encryptViaProxy = async (plainUrl) => {
  if (!plainUrl) return '';
  try {
    const res = await axios.get(route('proxy.get'), {
      params: {
        endpoint: 'encrypt',
        message: plainUrl
      }
    })
    return res.data.encrypted || '';
  } catch (e) {
    console.warn('Encryption failed for URL:', plainUrl, e);
    return ''; 
  }
};

const submitForm = async () => {
  formSubmitting.value = true;
  message.value = '';
  error.value = null;

  try {
    validateForm();

    const encryptedUrl = form.url ? await encryptViaProxy(form.url) : '';
    const encryptedDash = form.dash_url ? await encryptViaProxy(form.dash_url) : '';
    const encryptedHls = form.hls_url ? await encryptViaProxy(form.hls_url) : '';

    const payload = {
      ...form, 
      url: encryptedUrl,
      dash_url: encryptedDash,
      hls_url: encryptedHls,
    };

    const res = await axios.post(route('proxy.post'), payload, {
      params: { endpoint: 'episode-insert' },
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    });

    if(res.data.status === 'success'){
    message.value = 'Episode added successfully!';
    const preservedToken = form.token; 
    Object.assign(form, getInitialFormState()); 
    form.token = preservedToken; 
    form.create_date = new Date().toISOString().split('T')[0];
    clearSelectedItem(); // Also clear the selected item info
    }
    else{
      error.value = res.data.message || 'Server processing error.';
      console.error("Server Error:", err.response.data);
    } 

  } catch (err) {
    if (err.response) {
      
    } else if (err.request) {
      error.value = 'No response from server. Check network or server status.';
      console.error("Network Error:", err.request);
    } else {
      error.value = err.message || 'An unexpected error occurred.';
      console.error("Client-side/Validation Error:", err.message);
    }
    message.value = `Failed: ${error.value}`;
  } finally {
    formSubmitting.value = false;
  }
};

defineExpose({ submitForm });
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 8px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent; /* Or use a background from your theme e.g., bg-gray-100 dark:bg-gray-800 */
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #cbd5e1; /* light mode scrollbar thumb */
  border-radius: 4px;
}
.dark .custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #4a5568; /* dark mode scrollbar thumb */
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: #a0aec0; /* light mode hover */
}
.dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: #718096; /* dark mode hover */
}
</style>