<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
          <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
            Add New Movie and Season
          </h1>
          <p class="mt-3 text-lg text-gray-500 dark:text-gray-400">
            Fill in the details below to add a new movie to your collection.
          </p>
        </div>
  
        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
          <form @submit.prevent="handleFormSubmit" class="p-6 sm:p-8">
            <!-- Movie Details Section -->
            <div class="mb-8">
              <div class="flex items-center mb-4">
                <div class="flex-shrink-0 bg-indigo-500 p-2 rounded-lg">
                  <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                  </svg>
                </div>
                <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">Movie Details</h2>
              </div>
  
              <div class="space-y-4">
                <!-- Movie ID Input with Blur Event -->
                <div>
                  <label for="movieId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Movie ID</label>
                  <div class="relative">
                    <input
                      id="movieId"
                      type="text"
                      v-model="movie.id"
                      @blur="checkMovieId"
                      placeholder="Enter ID and click away to check"
                      required
                      class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                    />
                    <span v-if="isCheckingId" class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-gray-500">Checking...</span>
                  </div>
                  <p v-if="movieExists" class="mt-2 text-sm text-green-600 dark:text-green-400">
                    Existing movie found: <span class="font-bold">{{ existingMovieTitle }}</span>. You are adding a new season.
                  </p>
                </div>
  
                <!-- Conditional fields for New Movies -->
                <template v-if="!movieExists">
                  <div>
                    <label for="movieTitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Movie Title</label>
                    <input
                id="movieTitle"
                type="text"
                v-model="movie.title"
                placeholder="e.g., The Vue Chronicles"
                required
                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
              />
                  </div>
  
                  <div>
                    <label for="movieImg" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Movie Image URL</label>
                    <input
                id="movieImg"
                type="url"
                v-model="movie.img"
                placeholder="https://example.com/image.jpg"
                required
                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
              />
                  </div>
                </template>
              </div>
            </div>
  
            <!-- ... Season and Episode sections are unchanged ... -->
            <div class="mb-8">
              <div class="flex items-center mb-4">
                <div class="flex-shrink-0 bg-purple-500 p-2 rounded-lg"><svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg></div>
                <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">Season Details</h2>
              </div>
              <div>
                <label for="seasonName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Season Document Name</label>
                <input
              id="seasonName"
              type="text"
              v-model="season.name"
              placeholder="e.g., season_1"
              required
              class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
            />
              </div>
            </div>
            <div class="mb-8">
              <div class="flex items-center mb-4">
                <div class="flex-shrink-0 bg-blue-500 p-2 rounded-lg"><svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></div>
                <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">Episode Details</h2>
              </div>
              <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                <label for="episodeId" class="sr-only">Episode ID</label>
                <input
                  id="episodeId"
                  type="text"
                  v-model="season.episode.id"
                  placeholder="Episode ID (e.g., ep1)"
                  required
                  class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm"
                />
              </div>
                <div>
                <label for="episodeTxt" class="sr-only">Episode Title</label>
                <input
                  id="episodeTxt"
                  type="text"
                  v-model="season.episode.txt"
                  placeholder="Episode Title"
                  required
                  class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm"
                />
              </div>

                </div>
              </div>
            </div>
  
            <!-- Submission and Feedback -->
        <div class="mt-8">
          <button
            type="submit"
            :disabled="isLoading"
            class="w-full flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            <svg v-if="isLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ isLoading ? 'Saving to Firestore...' : 'Save to Firestore' }}
          </button>

          <div v-if="message" :class="['mt-4 p-4 rounded-lg', isError ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300' : 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300']">
            <div class="flex items-center">
              <svg :class="['flex-shrink-0 h-5 w-5', isError ? 'text-red-500 dark:text-red-400' : 'text-green-500 dark:text-green-400']" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path v-if="isError" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="ml-3">{{ message }}</span>
            </div>
          </div>
        </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { reactive, ref } from 'vue';
  import { db } from '@/firebase'; 
  import { doc, getDoc, writeBatch } from 'firebase/firestore';
  
  // Form Data State
  const movie = reactive({ id: '', title: '', img: '' });
  const season = reactive({ name: '', episode: { id: '', txt: '' } });
  
  // UI and Logic State
  const isLoading = ref(false);
  const message = ref('');
  const isError = ref(false);
  const movieExists = ref(false);
  const isCheckingId = ref(false);
  const existingMovieTitle = ref('');
  
  /**
   * Checks Firestore to see if a movie with the entered ID already exists.
   * This is triggered when the user clicks away from the Movie ID input.
   */
  const checkMovieId = async () => {
    const id = movie.id.trim();
    if (!id) {
      movieExists.value = false; // Reset if input is cleared
      return;
    }
    
    isCheckingId.value = true;
    try {
      const movieRef = doc(db, 'movie', id);
      const docSnap = await getDoc(movieRef);
  
      if (docSnap.exists()) {
        movieExists.value = true;
        existingMovieTitle.value = docSnap.data().title;
        // Clear local data as it's not needed for the form
        movie.title = '';
        movie.img = '';
      } else {
        movieExists.value = false;
        existingMovieTitle.value = '';
      }
    } catch (error) {
      console.error("Error checking movie ID:", error);
      message.value = "Could not verify movie ID.";
      isError.value = true;
    } finally {
      isCheckingId.value = false;
    }
  };
  
  
  /**
   * Handles the form submission with conditional logic based on whether
   * the movie already exists.
   */
  const handleFormSubmit = async () => {
    // Enhanced validation
    if (!movie.id || !season.name || !season.episode.id || !season.episode.txt) {
      message.value = 'Movie ID, Season, and Episode fields are required.';
      isError.value = true;
      return;
    }
    // If it's a new movie, title and image are also required
    if (!movieExists.value && (!movie.title || !movie.img)) {
      message.value = 'Movie Title and Image URL are required for new movies.';
      isError.value = true;
      return;
    }
  
    isLoading.value = true;
    message.value = '';
    isError.value = false;
  
    try {
      const batch = writeBatch(db);
      const seasonRef = doc(db, `movie/${movie.id}/season/${season.name}`);
      const seasonData = { ...season.episode };
  
      if (movieExists.value) {
        // --- Case 1: MOVIE EXISTS ---
        // We only need to create the new season document.
        batch.set(seasonRef, seasonData);
        message.value = `Successfully added season "${season.name}" to "${existingMovieTitle.value}"!`;
      } else {
        // --- Case 2: NEW MOVIE ---
        // We create both the movie document and the season document.
        const movieRef = doc(db, 'movie', movie.id);
        const movieData = { title: movie.title, img: movie.img };
        batch.set(movieRef, movieData);
        batch.set(seasonRef, seasonData);
        message.value = `Successfully saved new movie "${movie.title}"!`;
      }
  
      await batch.commit();
      isError.value = false;
  
      // Optional: Reset form after successful submission
      // movie.id = ''; movie.title = ''; movie.img = '';
      // season.name = ''; season.episode.id = ''; season.episode.txt = '';
      // movieExists.value = false;
  
    } catch (error) {
      console.error("Error writing document: ", error);
      message.value = `Failed to save data: ${error.message}`;
      isError.value = true;
    } finally {
      isLoading.value = false;
    }
  };
  </script>