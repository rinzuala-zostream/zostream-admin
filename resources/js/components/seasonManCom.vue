<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
          Manage Movie Collection
        </h1>
        <p class="mt-3 text-lg text-gray-500 dark:text-gray-400">
          Search for a movie by its ID to manage its details and seasons.
        </p>
      </div>

      <!-- Search Section -->
      <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 sm:p-8 mb-8">
        <form @submit.prevent="handleSearch" class="flex flex-col sm:flex-row gap-4">
          <input
            id="searchId"
            type="text"
            v-model="searchId"
            placeholder="Enter Movie ID to search..."
            required
            class="flex-grow w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
          />
          <button
            type="submit"
            :disabled="isSearching"
            class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            <svg v-if="isSearching" class="animate-spin -ml-1 mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            {{ isSearching ? 'Searching...' : 'Search' }}
          </button>
        </form>
      </div>

      <!-- Feedback Section -->
      <div v-if="message" :class="['p-4 rounded-lg text-center mb-6', isError ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300' : 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300']">
        {{ message }}
      </div>

      <!-- Found Movie and Seasons Section -->
      <div v-if="foundMovie" class="animate-fade-in space-y-8">
        <!-- Main Movie Info Card with Actions -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 sm:p-8">
          <div class="sm:flex sm:items-start sm:gap-6">
            <img :src="foundMovie.img" alt="Movie Poster" class="w-full sm:w-32 h-48 object-cover rounded-lg shadow-md mb-4 sm:mb-0">
            <div class="flex-grow">
              <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ foundMovie.title }}</h2>
              <p class="text-sm text-gray-500 dark:text-gray-400">Movie ID: {{ foundMovie.id }}</p>
            </div>
            <div class="flex-shrink-0 flex gap-2">
              <button @click="openMovieEditModal" class="p-2 rounded-full transition-colors duration-200 bg-blue-100 text-blue-700 hover:bg-blue-200" title="Edit Movie Details">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
              </button>
              <button @click="openMovieDeleteModal" class="p-2 rounded-full transition-colors duration-200 bg-red-100 text-red-700 hover:bg-red-200" title="Delete Entire Movie">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
              </button>
            </div>
          </div>
        </div>
        
        <!-- Season Cards Section -->
        <div v-if="foundMovie.seasons.length > 0">
          <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Seasons ({{ foundMovie.seasons.length }})</h3>
          <div class="space-y-4">
            <div v-for="season in foundMovie.seasons" :key="season.name" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-5">
              <div class="flex justify-between items-start">
                <div>
                  <h4 class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ season.name }}</h4>
                  <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    <p><span class="font-medium">ID:</span> {{ season.id }}</p>
                    <p><span class="font-medium">Txt:</span> {{ season.txt }}</p>
                  </div>
                </div>
                <div class="flex-shrink-0 flex gap-2">
                  <button @click="openSeasonEditModal(season)" class="p-2 rounded-full transition-colors duration-200 bg-blue-100 text-blue-700 hover:bg-blue-200" title="Edit Season">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                  </button>
                  <button @click="openSeasonDeleteModal(season)" class="p-2 rounded-full transition-colors duration-200 bg-red-100 text-red-700 hover:bg-red-200" title="Delete Season">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- MODALS -->
      <!-- Movie Edit Modal -->
      <div v-if="showMovieEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center p-4 z-50 animate-fade-in">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-lg">
          <form @submit.prevent="handleMovieUpdate">
            <div class="p-6 sm:p-8">
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Edit Movie Details</h3>
              <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Movie ID: {{ foundMovie.id }} (cannot be changed)</p>
              <div class="space-y-4">
                <div>
                  <label for="editMovieTitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Movie Title</label>
                  <input id="editMovieTitle" type="text" v-model="movieEditData.title" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" />
                </div>
                <div>
                  <label for="editMovieImg" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Movie Image URL</label>
                  <input id="editMovieImg" type="url" v-model="movieEditData.img" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" />
                </div>
              </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3">
              <button type="button" @click="showMovieEditModal = false" class="inline-flex justify-center px-4 py-2 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 border border-gray-300 dark:border-gray-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">Cancel</button>
              <button type="submit" :disabled="isUpdating" class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">{{ isUpdating ? 'Saving...' : 'Save Changes' }}</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Season Edit Modal -->
      <div v-if="showSeasonEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center p-4 z-50 animate-fade-in">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-lg">
          <form @submit.prevent="handleSeasonUpdate">
            <div class="p-6 sm:p-8">
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Edit Season: {{ originalSeasonName }}</h3>
              <div class="space-y-4">
                <div>
                  <label for="editSeasonName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Season Document Name</label>
                  <input id="editSeasonName" type="text" v-model="seasonEditData.name" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" />
                </div>
                <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                   <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-2">{{seasonEditData.name}}</h4>
                   <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                     <input type="text" v-model="seasonEditData.id" placeholder="id" required class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" />
                     <input type="text" v-model="seasonEditData.txt" placeholder="txt" required class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" />
                   </div>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3">
              <button type="button" @click="showSeasonEditModal = false" class="inline-flex justify-center px-4 py-2 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 border border-gray-300 dark:border-gray-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">Cancel</button>
              <button type="submit" :disabled="isUpdating" class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">{{ isUpdating ? 'Saving...' : 'Save Changes' }}</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Movie Delete Confirmation Modal -->
      <div v-if="showMovieDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center p-4 z-50 animate-fade-in">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Confirm Movie Deletion</h3>
            <p class="text-gray-600 dark:text-gray-300 my-4" v-if="movieToDelete">
              Are you sure you want to delete <strong class="text-red-500">{{ movieToDelete.title }}</strong>? This will remove the movie and ALL {{ movieToDelete.seasons.length }} of its seasons permanently. This action cannot be undone.
            </p>
            <div class="bg-gray-50 dark:bg-gray-800/50 -m-6 mt-6 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3 rounded-b-lg">
              <button @click="showMovieDeleteModal = false" class="inline-flex justify-center px-4 py-2 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 border border-gray-300 dark:border-gray-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">Cancel</button>
              <button @click="confirmMovieDelete" :disabled="isDeleting" class="inline-flex justify-center px-4 py-2 text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">{{ isDeleting ? 'Deleting...' : 'Confirm Delete' }}</button>
            </div>
        </div>
      </div>

      <!-- Season Delete Confirmation Modal -->
      <div v-if="showSeasonDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center p-4 z-50 animate-fade-in">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Confirm Season Deletion</h3>
            <p class="text-gray-600 dark:text-gray-300 my-4" v-if="seasonToDelete">
              Are you sure you want to delete only the season <strong class="text-red-500">{{ seasonToDelete.name }}</strong>? The movie and other seasons will not be affected.
            </p>
            <div class="bg-gray-50 dark:bg-gray-800/50 -m-6 mt-6 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3 rounded-b-lg">
              <button @click="showSeasonDeleteModal = false" class="inline-flex justify-center px-4 py-2 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 border border-gray-300 dark:border-gray-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">Cancel</button>
              <button @click="confirmSeasonDelete" :disabled="isDeleting" class="inline-flex justify-center px-4 py-2 text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">{{ isDeleting ? 'Deleting...' : 'Confirm Delete' }}</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { db } from '@/firebase';
import { doc, getDoc, getDocs, collection, writeBatch, deleteDoc, updateDoc } from 'firebase/firestore';

// --- State ---
const searchId = ref('');
const isSearching = ref(false);
const isUpdating = ref(false);
const isDeleting = ref(false);
const message = ref('');
const isError = ref(false);

const foundMovie = ref(null);
const movieToDelete = ref(null);
const seasonToDelete = ref(null);
const originalSeasonName = ref('');

// Modal visibility state
const showMovieEditModal = ref(false);
const showSeasonEditModal = ref(false);
const showMovieDeleteModal = ref(false);
const showSeasonDeleteModal = ref(false);

// State for edit forms
const movieEditData = reactive({ title: '', img: '' });
const seasonEditData = reactive({ name: '', id: '', txt: '' });

// --- Search ---
const handleSearch = async () => {
  if (!searchId.value.trim()) return;
  isSearching.value = true;
  foundMovie.value = null;
  message.value = '';
  isError.value = false;
  try {
    const movieRef = doc(db, 'movie', searchId.value);
    const movieDoc = await getDoc(movieRef);
    if (!movieDoc.exists()) throw new Error(`Movie with ID "${searchId.value}" not found.`);

    const seasonCollectionRef = collection(db, `movie/${searchId.value}/season`);
    const seasonSnapshot = await getDocs(seasonCollectionRef);
    const seasons = seasonSnapshot.docs.map(d => ({ name: d.id, ...d.data() }));

    foundMovie.value = {
      id: movieDoc.id,
      title: movieDoc.data().title,
      img: movieDoc.data().img,
      seasons: seasons,
    };
  } catch (error) {
    message.value = error.message;
    isError.value = true;
  } finally {
    isSearching.value = false;
  }
};

// --- Movie Actions ---
const openMovieEditModal = () => {
  if (!foundMovie.value) return;
  movieEditData.title = foundMovie.value.title;
  movieEditData.img = foundMovie.value.img;
  showMovieEditModal.value = true;
};

const handleMovieUpdate = async () => {
  isUpdating.value = true;
  try {
    const movieRef = doc(db, 'movie', foundMovie.value.id);
    await updateDoc(movieRef, { ...movieEditData });
    showMovieEditModal.value = false;
    message.value = 'Movie details updated successfully!';
    await handleSearch();
  } catch (error) {
    alert(`Update failed: ${error.message}`);
  } finally {
    isUpdating.value = false;
  }
};

const openMovieDeleteModal = () => {
  movieToDelete.value = foundMovie.value;
  showMovieDeleteModal.value = true;
};

const confirmMovieDelete = async () => {
  if (!movieToDelete.value) return;
  isDeleting.value = true;
  try {
    const batch = writeBatch(db);
    const movieRef = doc(db, 'movie', movieToDelete.value.id);
    
    // Delete all season sub-documents first
    const seasonCollectionRef = collection(db, `movie/${movieToDelete.value.id}/season`);
    const seasonSnapshot = await getDocs(seasonCollectionRef);
    seasonSnapshot.forEach(d => batch.delete(d.ref));
    
    // Then delete the main movie document
    batch.delete(movieRef);
    await batch.commit();

    message.value = `Successfully deleted movie: ${movieToDelete.value.title}`;
    showMovieDeleteModal.value = false;
    foundMovie.value = null;
    movieToDelete.value = null;
    searchId.value = ''; // Clear search input
  } catch (error) {
    message.value = `Failed to delete movie: ${error.message}`;
    isError.value = true;
  } finally {
    isDeleting.value = false;
  }
};

// --- Season Actions ---
const openSeasonEditModal = (season) => {
  seasonEditData.name = season.name;
  seasonEditData.id = season.id;
  seasonEditData.txt = season.txt;
  originalSeasonName.value = season.name;
  showSeasonEditModal.value = true;
};

const handleSeasonUpdate = async () => {
  isUpdating.value = true;
  try {
    const batch = writeBatch(db);
    const seasonData = { id: seasonEditData.id, txt: seasonEditData.txt };

    if (seasonEditData.name !== originalSeasonName.value) {
      const oldSeasonRef = doc(db, `movie/${foundMovie.value.id}/season/${originalSeasonName.value}`);
      const newSeasonRef = doc(db, `movie/${foundMovie.value.id}/season/${seasonEditData.name}`);
      batch.delete(oldSeasonRef);
      batch.set(newSeasonRef, seasonData);
    } else {
      const seasonRef = doc(db, `movie/${foundMovie.value.id}/season/${seasonEditData.name}`);
      batch.update(seasonRef, seasonData);
    }
    await batch.commit();
    showSeasonEditModal.value = false;
    message.value = 'Season updated successfully!';
    await handleSearch();
  } catch (error) {
    alert(`Update failed: ${error.message}`);
  } finally {
    isUpdating.value = false;
  }
};

const openSeasonDeleteModal = (season) => {
  seasonToDelete.value = season;
  showSeasonDeleteModal.value = true;
};

const confirmSeasonDelete = async () => {
  if (!seasonToDelete.value) return;
  isDeleting.value = true;
  try {
    const seasonRef = doc(db, `movie/${foundMovie.value.id}/season/${seasonToDelete.value.name}`);
    await deleteDoc(seasonRef);

    const index = foundMovie.value.seasons.findIndex(s => s.name === seasonToDelete.value.name);
    if (index > -1) foundMovie.value.seasons.splice(index, 1);
    
    message.value = `Successfully deleted season: ${seasonToDelete.value.name}`;
    showSeasonDeleteModal.value = false;
    seasonToDelete.value = null;
  } catch (error) {
    message.value = `Failed to delete season: ${error.message}`;
    isError.value = true;
  } finally {
    isDeleting.value = false;
  }
};
</script>

<style>
@keyframes fade-in {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
.animate-fade-in {
  animation: fade-in 0.2s ease-out forwards;
}
</style>