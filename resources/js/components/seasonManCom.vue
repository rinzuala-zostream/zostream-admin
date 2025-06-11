<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
          <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
            Seach/Edit Season ID
          </h1>
          <p class="mt-3 text-lg text-gray-500 dark:text-gray-400">
            Search for a movie by its ID to edit or delete it.
          </p>
        </div>
  
        <!-- Search Section -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 sm:p-8 mb-8">
          <form @submit.prevent="handleSearch" class="flex flex-col sm:flex-row gap-4">
            <label for="searchId" class="sr-only">Search by Movie ID</label>
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
              class="flex justify-center items-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
              <!-- Loading Spinner -->
              <svg v-if="isSearching" class="animate-spin -ml-1 mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
              {{ isSearching ? 'Searching...' : 'Search' }}
            </button>
          </form>
        </div>
  
        <!-- Results and Feedback Section -->
        <div v-if="message" :class="['p-4 rounded-lg text-center', isError ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300' : 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300']">
          {{ message }}
        </div>
  
         <!-- REFINED: Found Movie Section -->
      <div v-if="foundMovie" class="animate-fade-in space-y-8">
        <!-- Main Movie Info Card -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 sm:p-8">
          <div class="sm:flex sm:items-start sm:gap-6">
            <img :src="foundMovie.img" alt="Movie Poster" class="w-full sm:w-32 h-48 object-cover rounded-lg shadow-md mb-4 sm:mb-0">
            <div class="flex-grow">
              <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ foundMovie.title }}</h2>
              <p class="text-sm text-gray-500 dark:text-gray-400">Movie ID: {{ foundMovie.id }}</p>
            </div>
          </div>
        </div>

        <!-- Section for Season Cards -->
        <div>
          <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Seasons ({{ foundMovie.seasons.length }})</h3>
          <div class="space-y-4">
            <!-- Loop through each season and create a card -->
            <div v-for="season in foundMovie.seasons" :key="season.name" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-5">
              <div class="flex justify-between items-start">
                <div>
                  <h4 class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ season.name }}</h4>
                  <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    <p><span class="font-medium">Episode ID:</span> {{ season.id }}</p>
                    <p><span class="font-medium">Episode Title:</span> {{ season.txt }}</p>
                  </div>
                </div>
                <div class="flex-shrink-0 flex gap-2">
                  <button @click="openEditModal(season)" class="btn-icon bg-blue-100 text-blue-700 hover:bg-blue-200" title="Edit Season">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                  </button>
                  <button @click="openDeleteModal(season)" class="btn-icon bg-red-100 text-red-700 hover:bg-red-200" title="Delete Season">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
        <!-- Edit Modal -->
    <div v-if="showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center p-4 z-50 animate-fade-in">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-lg overflow-hidden transform transition-all sm:my-8">
        <form @submit.prevent="handleUpdate">
          <div class="p-6 sm:p-8">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Edit Movie: {{ editData.title }}</h3>
            
            <div class="space-y-4">
              <div>
                <label for="editMovieTitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Movie Title</label>
                <input id="editMovieTitle" type="text" v-model="editData.title" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" />
              </div>
              <div>
                <label for="editMovieImg" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Movie Image URL</label>
                <input id="editMovieImg" type="url" v-model="editData.img" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" />
              </div>
              <div>
                <label for="editSeasonDoc" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Seson Doc</label>
                <input id="editSeasonDoc" type="text" v-model="editData.season.name" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" />
              </div>
              <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                 <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-2">Episode Details</h4>
                 <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                   <input type="text" v-model="editData.season.id" placeholder="Episode ID" required class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500" />
                   <input type="text" v-model="editData.season.txt" placeholder="Episode Title" required class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500" />
                 </div>
              </div>
            </div>
          </div>
          
          <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3">
            <button type="submit" :disabled="isUpdating" class="w-full sm:w-auto px-4 py-2 text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50">
              {{ isUpdating ? 'Saving...' : 'Save Changes' }}
            </button>
            <button type="button" @click="closeEditModal" class="w-full sm:w-auto px-4 py-2 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 border border-gray-300 dark:border-gray-500">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  
        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center p-4 z-50 animate-fade-in">
          <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Confirm Deletion</h3>
            <p class="text-gray-600 dark:text-gray-300 my-4">
              Are you sure you want to delete "{{ foundMovie.title }}"? This will remove the movie and its season data permanently. This action cannot be undone.
            </p>
            <div class="flex justify-end gap-4 mt-6">
              <button @click="showDeleteModal = false" class="btn-secondary">Cancel</button>
              <button @click="confirmDelete" :disabled="isDeleting" class="btn-danger">
                {{ isDeleting ? 'Deleting...' : 'Confirm Delete' }}
              </button>
            </div>
          </div>
        </div>
  
      </div>
    </div>
  </template>
  
  <script setup>
import { ref, reactive } from 'vue';
import { db } from '@/firebase'; // Adjust this path if needed
import { doc, getDoc, getDocs, collection, writeBatch, deleteDoc } from 'firebase/firestore';

// --- State Management ---
const searchId = ref('');
const isSearching = ref(false);
const isUpdating = ref(false);
const isDeleting = ref(false);

const foundMovie = ref(null);
const message = ref('');
const isError = ref(false);

const showEditModal = ref(false);
const showDeleteModal = ref(false);
const seasonToDelete = ref(null);
const originalSeasonName = ref('');

// Holds movie and a single season data for the edit form
const editData = reactive({
  id: '',
  title: '',
  img: '',
  season: { name: '', id: '', txt: '' }
});


// --- Search Logic ---
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

    // REFINED: Get ALL documents from the season subcollection
    const seasonCollectionRef = collection(db, `movie/${searchId.value}/season`);
    const seasonSnapshot = await getDocs(seasonCollectionRef);

    const seasons = seasonSnapshot.docs.map(doc => ({
      name: doc.id,
      ...doc.data()
    }));

    if (seasons.length === 0) throw new Error(`No season data found for this movie.`);

    foundMovie.value = {
      id: movieDoc.id,
      title: movieDoc.data().title,
      img: movieDoc.data().img,
      seasons: seasons // Store all seasons in an array
    };
  } catch (error) {
    message.value = error.message;
    isError.value = true;
  } finally {
    isSearching.value = false;
  }
};


// --- Delete Logic (Scoped to one season) ---
const openDeleteModal = (season) => {
  seasonToDelete.value = season;
  showDeleteModal.value = true;
};

const confirmDelete = async () => {
  if (!seasonToDelete.value) return;
  isDeleting.value = true;

  try {
    const seasonRef = doc(db, `movie/${foundMovie.value.id}/season/${seasonToDelete.value.name}`);
    await deleteDoc(seasonRef);

    // Remove the deleted season from the local array for instant UI update
    const index = foundMovie.value.seasons.findIndex(s => s.name === seasonToDelete.value.name);
    if (index > -1) {
      foundMovie.value.seasons.splice(index, 1);
    }
    
    message.value = `Successfully deleted season: ${seasonToDelete.value.name}`;
    isError.value = false;
    showDeleteModal.value = false;
    seasonToDelete.value = null;

  } catch (error) {
    message.value = `Failed to delete season: ${error.message}`;
    isError.value = true;
  } finally {
    isDeleting.value = false;
  }
};


// --- Edit Logic (Scoped to one season) ---
const openEditModal = (season) => {
  // Populate the form with the movie data and the specific season data
  editData.id = foundMovie.value.id;
  editData.title = foundMovie.value.title;
  editData.img = foundMovie.value.img;
  editData.season = JSON.parse(JSON.stringify(season)); // Deep copy of the season
  originalSeasonName.value = season.name; // Keep track of the original name for renaming logic
  showEditModal.value = true;
};

const closeEditModal = () => showEditModal.value = false;

const handleUpdate = async () => {
  isUpdating.value = true;
  const batch = writeBatch(db);

  try {
    // 1. Update the main movie document (title, img)
    const movieRef = doc(db, 'movie', editData.id);
    batch.update(movieRef, { title: editData.title, img: editData.img });

    const seasonData = { id: editData.season.id, txt: editData.season.txt };
    
    // 2. Handle the season document (update or rename)
    if (editData.season.name !== originalSeasonName.value) {
      // If the season name changed, we must delete the old doc and create a new one.
      const oldSeasonRef = doc(db, `movie/${editData.id}/season/${originalSeasonName.value}`);
      const newSeasonRef = doc(db, `movie/${editData.id}/season/${editData.season.name}`);
      batch.delete(oldSeasonRef);
      batch.set(newSeasonRef, seasonData);
    } else {
      // If the name is the same, just update the existing document.
      const seasonRef = doc(db, `movie/${editData.id}/season/${editData.season.name}`);
      batch.update(seasonRef, seasonData);
    }

    // 3. Commit all operations
    await batch.commit();
    closeEditModal();
    message.value = 'Update successful!';
    isError.value = false;
    
    // 4. Refresh the data on the page to show all changes
    await handleSearch();

  } catch (error) {
    alert(`Update failed: ${error.message}`);
  } finally {
    isUpdating.value = false;
  }
};
</script>