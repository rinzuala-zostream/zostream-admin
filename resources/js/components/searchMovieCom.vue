<template>
  <div class="p-4 min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <div class="max-w-4xl mx-auto">

      <!-- Header -->
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Movie Collection</h1>
      </div>

      <!-- Search and Sort Controls -->
      <div class="mb-6">
        <div class="flex flex-col sm:flex-row gap-4 mb-3">
          <div class="relative flex-grow">
            <input type="text" v-model="search" placeholder="Enter movie title..." @keyup.enter="performSearch"
              class="w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 transition-all duration-200" />
            <button v-if="search" @click="search = ''"
              class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
              ✕
            </button>
          </div>

          <select v-model="sortOrder"
            class="px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 transition-all duration-200 sm:w-auto w-full">
            <option value="asc">A-Z</option>
            <option value="desc">Z-A</option>
          </select>
        </div>

        <div class="flex justify-center">
          <button @click="performSearch" :disabled="loading"
            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed w-full sm:w-auto">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <span>Search</span>
          </button>
        </div>
      </div>

      <!-- Loading Spinner -->
      <div v-if="loading && !showEditModal && !showDeleteConfirmModal" class="flex justify-center items-center py-12">
        <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-blue-500"></div>
      </div>

      <!-- Main Content -->
      <div v-else-if="!showEditModal && !showDeleteConfirmModal">

        <!-- Initial Prompt -->
        <div v-if="!hasSearchedAtLeastOnce" class="text-center py-12">
          <div class="mx-auto w-24 h-24 text-gray-400 dark:text-gray-500 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="1">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M10 7v3m0 0v3m0-3h3m-3 0H7" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">Find Your Favorite Movies</h3>
          <p class="text-gray-500 dark:text-gray-400 mt-1">Enter a movie title and click the search button to begin.</p>
        </div>

        <!-- No Results -->
        <div v-else-if="filteredMovies.length === 0" class="text-center py-12">
          <div class="mx-auto w-24 h-24 text-gray-400 dark:text-gray-500 mb-4">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">No movies found</h3>
          <p class="text-gray-500 dark:text-gray-400 mt-1">Try adjusting your search query or check for typos.</p>
        </div>

        <!-- Movie Results -->
        <ul v-else class="space-y-2">
          <li v-for="movie in filteredMovies" :key="movie.id"
              class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden border border-gray-200 dark:border-gray-700">
            
            <!-- Movie Header -->
            <div class="flex items-center justify-between p-4">
              <div class="flex items-center space-x-3 min-w-0 flex-grow cursor-pointer" @click="toggleMovie(movie)">
                <div
                  class="w-10 h-10 flex-shrink-0 rounded-lg bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                  <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                       viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                  </svg>
                </div>
                <span class="font-medium truncate">{{ movie.title }}</span>
              </div>

              <!-- Movie ID -->
              <span class="px-2 py-0.5 bg-gray-200 dark:bg-gray-700 text-xs text-gray-700 dark:text-gray-300 rounded font-mono mx-2">
                {{ movie.id }}
              </span>

              <!-- Movie Status -->
              <div class="flex-shrink-0 mx-4" v-if="movie.status">
                <span :class="getStatusClass(movie.status)"
                      class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize">
                  {{ movie.status }}
                </span>
              </div>

              <!-- Action Buttons -->
              <div class="flex space-x-2 flex-shrink-0">
                <button
                  class="px-3 py-1.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center space-x-1 disabled:opacity-70 disabled:cursor-wait"
                  @click.stop="editMovie(movie)"
                  :disabled="isFetchingEditItemDetails && editingItemContext?.id === movie.id && !editingItemContext?.seasonId">
                  <svg v-if="isFetchingEditItemDetails && editingItemContext?.id === movie.id && !editingItemContext?.seasonId"
                       class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                       viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291..." />
                  </svg>
                  <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                       xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5..." />
                  </svg>
                  <span>Edit</span>
                </button>

                <button
                  class="px-3 py-1.5 text-sm bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200 flex items-center space-x-1"
                  @click.stop="openDeleteConfirmation(movie)">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                       xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2..." />
                  </svg>
                  <span>Delete</span>
                </button>
              </div>
            </div>

            <!-- Seasons -->
            <transition name="fade">
              <div v-if="expandedMovie === movie.id && movie.isSeason"
                   class="border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30 transition-all duration-200">
                <div v-for="season in movie.seasons || []" :key="season.id" class="px-4 py-3">
                  <div class="flex items-center justify-between font-medium text-sm">
                    <div @click="toggleSeasonEpisodes(movie, season)"
                         class="flex items-center space-x-2 cursor-pointer hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-150">
                      <svg class="w-4 h-4 transform transition-transform duration-200"
                           :class="{ 'rotate-90': season.showEpisodes }" fill="none" stroke="currentColor"
                           viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5l7 7-7 7" />
                      </svg>
                      <div class="flex items-center gap-2">
                        <span>{{ season.txt }}</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 font-mono">{{ season.id }}</span>
                      </div>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                      {{ season.episodes.length }} episode{{ season.episodes.length !== 1 ? 's' : '' }}
                    </span>
                  </div>

                  <!-- Episodes -->
                  <transition name="fade">
                    <ul v-if="season.showEpisodes" class="ml-6 mt-2 space-y-2 animate-fadeIn">
                      <li v-for="ep in season.episodes" :key="ep.id"
                          class="flex items-center justify-between py-2 px-3 -mx-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors duration-150">
                        <div class="flex items-center space-x-3">
                          <span class="text-sm">{{ ep.txt || 'Untitled Episode' }}</span>
                          <span class="text-xs text-gray-500 dark:text-gray-400 font-mono">{{ ep.id }}</span>
                        </div>
                        <!-- Add your episode buttons here -->
                      </li>
                    </ul>
                  </transition>
                </div>
              </div>
            </transition>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { db } from '@/firebase'; // Used for toggleMovie, toggleSeasonEpisodes (local Firestore data)
import { collection, getDocs } from 'firebase/firestore';

// --- Configuration ---
// IMPORTANT: For production, use environment variables and ideally a backend proxy for API keys.
const ZOS_API_KEY = import.meta.env.VITE_ZOS_API_KEY || 'ljkfdnakadsfthbretmjsavbigruw3niadghr67errh8';
const ZOS_BASE_URL = 'https://apis.zostream.in/api'; // Centralize base URL

// --- Reactive State ---
const movies = ref([]);
const search = ref('');
const sortOrder = ref('asc');
const loading = ref(false); // Main search loading
const expandedMovie = ref(null);
const hasSearchedAtLeastOnce = ref(false);

const showDeleteConfirmModal = ref(false);
const itemToDelete = ref(null); // Will store { id, type: 'movie' | 'episode', titleOrTxt, parentMovieId?, parentSeasonId? }
const isDeleting = ref(false);
const deleteModalMessage = ref('');

// Modal State
const showEditModal = ref(false);
const editingItem = ref(null); // { id (movie/ep ID), movieId?, seasonId? }
const editForm = ref({});
const modalLoading = ref(false); // Modal submission loading
const modalMessage = ref('');
const isFetchingEditItemDetails = ref(false);
const editingItemContext = ref(null); // { id, seasonId? } for loading spinner on edit button

// --- Form Field Definitions ---
const movieBooleanFields = ref({
  isProtected: 'Protected', isBollywood: 'Bollywood', isCompleted: 'Completed',
  isDocumentary: 'Documentary', isAgeRestricted: 'Age Restricted', isDubbed: 'Dubbed',
  isEnable: 'Enable', isHollywood: 'Hollywood', isKorean: 'Korean', isMizo: 'Mizo',
  isPayPerView: 'Pay Per View', isPremium: 'Premium', isSeason: 'Season',
  isSubtitle: 'Has Subtitle'
});

const episodeBooleanFields = ref({
  isProtected: 'Protected',
  isEnable: 'Enable',
  isPPV: 'Pay Per View', // Assuming this maps to an API field like isPayPerView or isPpv
  isPremium: 'Premium',
});

const getInitialMovieForm = () => ({
  title: '', description: '', genre: '', director: '', duration: '',
  ppv_amount: '', status: '', create_date: '', poster: '', cover_img: '',
  release_on: '', url: '', dash_url: '', hls_url: '',
  ...Object.fromEntries(Object.keys(movieBooleanFields.value).map(key => [key, false]))
});

const getInitialEpisodeForm = () => ({
  title: '', desc: '', txt: '', season_id: '', ppv_amount: '',
  img: '', url: '', dash_url: '', hls_url: '', status: '', create_date: '',
  ...Object.fromEntries(Object.keys(episodeBooleanFields.value).map(key => [key, false]))
});

// --- Utility Functions ---
const formatDateForInput = (dateStringOrTimestamp) => {
  if (!dateStringOrTimestamp) return '';
  try {
    const date = new Date(
      typeof dateStringOrTimestamp === 'object' && dateStringOrTimestamp.seconds
        ? dateStringOrTimestamp.seconds * 1000
        : dateStringOrTimestamp
    );
    if (isNaN(date.valueOf())) return '';
    return date.toISOString().split('T')[0];
  } catch (e) { return ''; }
};

const decryptUrl = async (urlToDecrypt) => {
  if (!urlToDecrypt || typeof urlToDecrypt !== 'string' || !urlToDecrypt.trim()) return '';
  try {
    const response = await axios.post(route('decrypt'), { encrypted_url: urlToDecrypt });
    return (response.data && typeof response.data.url === 'string') ? response.data.url : urlToDecrypt;
  } catch (error) {
    console.error('Decryption failed:', urlToDecrypt, error.response?.data || error.message);
    return urlToDecrypt;
  }
};

const encryptViaProxy = async (plainUrl) => {
  if (!plainUrl || typeof plainUrl !== 'string' || !plainUrl.trim()) return '';
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
};

const fetchMovies = async (query = '') => {
  loading.value = true;
  movies.value = [];
  try {
    const response = await axios.get(route('proxy.get', {
      endpoint: 'search',
      q: query,
      age_restriction: String(true),
      is_enable: String(false),
    }));
    movies.value = Array.isArray(response.data) ? response.data : [];
  } catch (error) {
    console.error('Failed to fetch movies:', error);
    movies.value = [];
  } finally {
    loading.value = false;
  }
};

const performSearch = async () => {
  hasSearchedAtLeastOnce.value = true;
  await fetchMovies(search.value.trim());
};

onMounted(() => { /* No initial fetch on component mount */ });

const filteredMovies = computed(() => {
  if (!Array.isArray(movies.value)) return [];
  return [...movies.value].sort((a, b) => {
    const titleA = String(a.title || '').toLowerCase();
    const titleB = String(b.title || '').toLowerCase();
    return sortOrder.value === 'asc' ? titleA.localeCompare(titleB) : titleB.localeCompare(titleA);
  });
});

const getStatusClass = (status) => {
  if (!status) return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'; // Default/Unknown
  status = status.toLowerCase();
  switch (status) {
    case 'published':
      return 'bg-green-100 text-green-800 dark:bg-green-700/30 dark:text-green-300';
    case 'draft':
      return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700/30 dark:text-yellow-400'; // Yellow for draft
    case 'scheduled':
      return 'bg-blue-100 text-blue-800 dark:bg-blue-700/30 dark:text-blue-400';
    default:
      return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
  }
};

const editMovie = async (itemFromList, pMovieId = null, pSeasonId = null) => {
  if (isFetchingEditItemDetails.value) return;

  isFetchingEditItemDetails.value = true;
  editingItemContext.value = { id: itemFromList.id, seasonId: pSeasonId || undefined };
  modalMessage.value = '';
  const isEpisode = !!pSeasonId;
  editForm.value = isEpisode ? getInitialEpisodeForm() : getInitialMovieForm();

  try {
    const itemIdToFetch = itemFromList.id;
    let itemDetails;

    if (isEpisode) {
      const episodeDetailUrl = `${ZOS_BASE_URL}/episode/${itemIdToFetch}`;
      const response = await axios.get(episodeDetailUrl, { headers: { 'X-Api-Key': ZOS_API_KEY } });

      itemDetails = response.data.episode;
      if (!itemDetails) throw new Error("Episode data not found in Zostream API response.");
      console.log("Fetched Zostream Episode Details:", itemDetails);
    } else { // Fetching movie details (assumed via your proxy)
      const response = await axios.get(route("proxy.get", { endpoint: "movies", id: itemIdToFetch, category_type: "movie", is_enable: false }));
      itemDetails = response.data; // Assuming proxy returns movie data directly
      if (!itemDetails) throw new Error("Movie data not found in proxy response.");
      console.log("Fetched Proxied Movie Details:", itemDetails);
    }

    // Standardize itemDetails structure check
    if (typeof itemDetails !== 'object' || Array.isArray(itemDetails)) {
      throw new Error(`Invalid item data structure. Expected a single object, got ${typeof itemDetails}.`);
    }

    const form = editForm.value;
    if (isEpisode) {
      form.title = itemDetails.title || itemDetails.name || '';
      form.desc = itemDetails.desc || itemDetails.description || '';
      form.txt = itemDetails.txt || ''; // This might be for display, API might not have/use it
      form.season_id = pSeasonId || itemDetails.season_id || ''; // API should provide season_id for an episode
      form.ppv_amount = itemDetails.ppv_amount || itemDetails.ppvAmount || ''; // Check API field name
      form.status = itemDetails.status || '';
      form.create_date = formatDateForInput(itemDetails.create_date || itemDetails.upload_date || itemDetails.createdAt);

      const epUrlFields = { img: 'img', url: 'url', dash_url: 'dash_url', hls_url: 'hls_url' };
      for (const [formKey, detailKey] of Object.entries(epUrlFields)) {
        form[formKey] = itemDetails[detailKey] ? await decryptUrl(itemDetails[detailKey]) : '';
      }
      for (const key in episodeBooleanFields.value) {
        form[key] = !!itemDetails[key]; // Map API boolean fields
      }
    } else { // Movie
      form.title = itemDetails.title || '';
      form.description = itemDetails.description || '';
      form.genre = itemDetails.genre || '';
      form.director = itemDetails.director || '';
      form.duration = itemDetails.duration || '';
      form.ppv_amount = itemDetails.ppv_amount || itemDetails.ppvAmount || '';
      form.status = itemDetails.status || '';
      form.create_date = formatDateForInput(itemDetails.create_date || itemDetails.upload_date || itemDetails.createdAt);
      form.release_on = formatDateForInput(itemDetails.release_on || itemDetails.releaseDate);

      const movieUrlFields = { poster: 'poster', cover_img: 'cover_img', url: 'url', dash_url: 'dash_url', hls_url: 'hls_url' };
      for (const [formKey, detailKey] of Object.entries(movieUrlFields)) {
        form[formKey] = itemDetails[detailKey] ? await decryptUrl(itemDetails[detailKey]) : '';
      }
      for (const key in movieBooleanFields.value) {
        form[key] = !!itemDetails[key];
      }
    }

    editingItem.value = { id: itemIdToFetch, movieId: pMovieId || (isEpisode ? null : itemIdToFetch), seasonId: pSeasonId };
    showEditModal.value = true;

  } catch (error) {
    console.error('Failed to prepare item for editing:', error.config?.url, error);
    let errorMessage = 'Unknown error loading details.';
    if (error.response) {
      errorMessage = `API Error (${error.response.status}): ${error.response.data?.message || error.response.statusText}`;
    } else if (error.request) {
      errorMessage = 'No response from server.';
    } else {
      errorMessage = error.message;
    }
    alert(`Error: ${errorMessage}`);
  } finally {
    isFetchingEditItemDetails.value = false;
    editingItemContext.value = null;
  }
};

const closeEditModal = () => {
  showEditModal.value = false;
  editingItem.value = null;
  editForm.value = {};
};

const submitForm = async () => {
  modalLoading.value = true;
  modalMessage.value = '';

  try {
    const currentFormState = JSON.parse(JSON.stringify(editForm.value));
    const itemCtx = editingItem.value;
    if (!itemCtx || !itemCtx.id) throw new Error("Editing context is invalid.");

    const isEpisode = !!itemCtx.seasonId;

    // 1. Encrypt URLs
    const urlFields = ['url', 'dash_url', 'hls_url'];
    const urlsToEncrypt = Object.fromEntries(
      urlFields.map((key) => [key, currentFormState[key]])
    );

    const encryptionPromises = Object.entries(urlsToEncrypt).map(async ([key, plainUrl]) =>
      plainUrl && typeof plainUrl === 'string' && plainUrl.trim()
        ? [key, (await encryptViaProxy(plainUrl)) || plainUrl]
        : [key, '']
    );

    const encryptedUrlsMap = Object.fromEntries(await Promise.all(encryptionPromises));

    // 2. Prepare payload
    const payload = {
      ...currentFormState,
      ...encryptedUrlsMap,
    };

    // 3. Normalize booleans
    const booleanFieldsConfig = isEpisode ? episodeBooleanFields.value : movieBooleanFields.value;
    for (const boolKey in booleanFieldsConfig) {
      payload[boolKey] = !!payload[boolKey];
    }

    // 4. Set endpoint and additional fields
    let apiSegment = 'movies';
    if (isEpisode) {
      payload.season_id = itemCtx.seasonId;
      apiSegment = 'episode';
    }

    const actualApiUrl = `${ZOS_BASE_URL}/${apiSegment}/${itemCtx.id}`;
    const apiHeaders = {
      'Content-Type': 'application/json',
      'X-Api-Key': ZOS_API_KEY,
    };

    console.log(`Submitting update to: ${actualApiUrl}`, "Payload:", payload);
    await axios.put(actualApiUrl, payload, { headers: apiHeaders });

    modalMessage.value = `${isEpisode ? 'Episode' : 'Movie'} updated successfully!`;

    // 5. Update local list
    if (isEpisode) {
      const movieToUpdate = movies.value.find(m => m.id === itemCtx.movieId);
      const seasonToUpdate = movieToUpdate?.seasons?.find(s => s.id === itemCtx.seasonId);
      const epIndex = seasonToUpdate?.episodes?.findIndex(e => e.id === itemCtx.id);

      if (epIndex !== undefined && epIndex !== -1) {
        seasonToUpdate.episodes[epIndex] = {
          ...seasonToUpdate.episodes[epIndex],
          ...editForm.value,
          txt: editForm.value.title || editForm.value.txt,
        };
      }
    } else {
      const movieIndex = movies.value.findIndex(m => m.id === itemCtx.id);
      if (movieIndex !== -1) {
        movies.value[movieIndex] = {
          ...movies.value[movieIndex],
          ...editForm.value,
        };
      }
    }

    // Optional: Automatically close modal
    // setTimeout(closeEditModal, 1500);
  } catch (err) {
    console.error('Update submission failed:', err.config?.url, err.response || err);
    let errorMsg = 'An unknown error occurred during update.';
    if (err.response) {
      errorMsg = `API Error (${err.response.status}): ${JSON.stringify(err.response.data?.errors || err.response.data?.message || err.response.data || err.response.statusText)}`;
    } else if (err.request) {
      errorMsg = 'No response from server.';
    } else {
      errorMsg = err.message;
    }
    modalMessage.value = `Update Failed: ${errorMsg.substring(0, 300)}`;
  } finally {
    modalLoading.value = false;
  }
};

// --- Helper: openDeleteConfirmation ---
const openDeleteConfirmation = (item, parentMovieId = null, parentSeasonId = null) => {
  const isEpisode = !!parentSeasonId;
  itemToDelete.value = {
    id: item.id,
    type: isEpisode ? 'episode' : 'movie',
    titleOrTxt: item.title || item.txt || 'this item', // For display in modal
    parentMovieId: parentMovieId,
    parentSeasonId: parentSeasonId
  };
  deleteModalMessage.value = ''; // Clear previous messages
  showDeleteConfirmModal.value = true;
};

// --- Helper: closeDeleteConfirmation ---
const closeDeleteConfirmation = () => {
  showDeleteConfirmModal.value = false;
  itemToDelete.value = null;
  isDeleting.value = false; // Reset deleting state
};

// --- Helper: confirmDeleteItem ---
const confirmDeleteItem = async () => {
  if (!itemToDelete.value) return;

  isDeleting.value = true;
  deleteModalMessage.value = '';
  const itemCtx = itemToDelete.value; // { id, type: 'movie' | 'episode', ... }

  try {
    // Determine the correct API path segment based on the item type
    let apiDeleteSegment = 'movies'; // Default for movies
    if (itemCtx.type === 'episode') {
      apiDeleteSegment = 'episode'; // Change to 'episode' for episodes
    }

    const actualApiUrl = `${ZOS_BASE_URL}/${apiDeleteSegment}/${itemCtx.id}`;
    const apiHeaders = {
      // 'Content-Type': 'application/json', // Usually not strictly needed for DELETE without body
      'X-Api-Key': ZOS_API_KEY,
    };

    console.log(`Attempting to DELETE: ${itemCtx.type} with ID ${itemCtx.id} from URL: ${actualApiUrl}`);

    await axios.delete(actualApiUrl, { headers: apiHeaders });

    deleteModalMessage.value = `${itemCtx.type.charAt(0).toUpperCase() + itemCtx.type.slice(1)} deleted successfully!`;

    // Remove item from local list
    if (itemCtx.type === 'episode') {
      const movieToUpdate = movies.value.find(m => m.id === itemCtx.parentMovieId);
      if (movieToUpdate?.seasons) {
        const seasonToUpdate = movieToUpdate.seasons.find(s => s.id === itemCtx.parentSeasonId);
        if (seasonToUpdate?.episodes) {
          seasonToUpdate.episodes = seasonToUpdate.episodes.filter(e => e.id !== itemCtx.id);
        }
      }
    } else { // Movie
      movies.value = movies.value.filter(m => m.id !== itemCtx.id);
    }

    setTimeout(() => {
      closeDeleteConfirmation();
      modalMessage.value = `${itemCtx.type.charAt(0).toUpperCase() + itemCtx.type.slice(1)} "${itemCtx.titleOrTxt}" was deleted.`;
      setTimeout(() => modalMessage.value = '', 3000);
    }, 1500);

  } catch (err) {
    console.error(`Failed to delete ${itemCtx.type}:`, err.config?.url, err.response || err);
    let errorMsg = `An unknown error occurred while deleting the ${itemCtx.type}.`;
    if (err.response) {
      errorMsg = `API Error (${err.response.status}) deleting ${itemCtx.type}: ${JSON.stringify(err.response.data?.errors || err.response.data?.message || err.response.data || err.response.statusText)}`;
    } else if (err.request) {
      errorMsg = `No response from server while deleting ${itemCtx.type}.`;
    } else {
      errorMsg = err.message;
    }
    deleteModalMessage.value = `Failed: ${errorMsg.substring(0, 250)}`;
  } finally {
    isDeleting.value = false;
  }
};

// Functions for expanding seasons/episodes (using local Firestore data)
const toggleMovie = async (movie) => {
  if (expandedMovie.value === movie.id) {
    expandedMovie.value = null; return;
  }
  expandedMovie.value = movie.id;
  // Fetch seasons from Firestore if movie.isSeason and seasons aren't loaded
  if (movie.isSeason && (!movie.seasons || movie.seasons.length === 0)) {
    try {
      const qSnap = await getDocs(collection(db, `movie/${movie.id}/season`)); // Check Firestore path
      movie.seasons = qSnap.docs.map(d => ({
        id: d.id, // Use Firestore doc ID for season
        ...(d.data()), // Spread other season data from Firestore
        txt: d.data().txt || d.data().title || `Season ${d.id.slice(-2)}`, // Prefer txt, then title
        episodes: [],
        showEpisodes: false
      })).sort((a, b) => (a.txt || '').localeCompare(b.txt || '', undefined, { numeric: true }));
    } catch (err) {
      console.error(`Error fetching seasons for movie ${movie.id}:`, err);
      movie.seasons = [];
    }
  }
};

const toggleSeasonEpisodes = async (movie, season) => {
  season.showEpisodes = !season.showEpisodes;
  // Fetch episodes for this season (from your proxy/API, not Firestore here based on original code)
  if (season.showEpisodes && (!season.episodes || season.episodes.length === 0)) {
    try {
      // This `id` should be the season's ID that your `proxy.get` endpoint expects
      const resp = await axios.get(route("proxy.get", { id: season.id, endpoint: "episodes", is_enable: false }));
      if (Array.isArray(resp.data)) {
        season.episodes = resp.data
          .filter(ep => ep && ep.id != null && String(ep.id).trim() !== '')
          .map(ep => ({
            ...ep, // Spread all properties from API response for the episode
            id: String(ep.id).trim(),
            txt: ep.txt || ep.title || ep.name || `Episode ${String(ep.id).trim()}` // Robust title/identifier
          }))
          .sort((a, b) => {
            const numA = parseInt(String(a.txt).match(/\d+/)?.[0] || String(a.id));
            const numB = parseInt(String(b.txt).match(/\d+/)?.[0] || String(b.id));
            if (!isNaN(numA) && !isNaN(numB)) return numA - numB;
            return (a.txt || '').localeCompare(b.txt || '', undefined, { numeric: true });
          });
      } else { season.episodes = []; }
    } catch (err) {
      console.error(`Failed to fetch episodes for season ${season.id}:`, err);
      season.episodes = [];
    }
  }
};

</script>

<style scoped>
/* ... (same styles as before) ... */
.animate-fadeIn {
  animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-5px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.form-container::-webkit-scrollbar {
  width: 8px;
}

.form-container::-webkit-scrollbar-track {
  background: transparent;
}

.form-container::-webkit-scrollbar-thumb {
  background-color: rgba(156, 163, 175, 0.5);
  border-radius: 4px;
}

.dark .form-container::-webkit-scrollbar-thumb {
  background-color: rgba(75, 85, 99, 0.5);
}
</style>