<template>
  <div class="max-w-10xl px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-800 transition-all duration-300">
      <!-- Form Header -->
      <div class="bg-gradient-to-r from-purple-500 to-indigo-600 dark:from-purple-600 dark:to-indigo-700 px-6 py-4 sm:px-8">
        <div class="flex items-center justify-between">
          <h2 class="text-2xl font-bold text-white tracking-tight flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
            </svg>
            Add New Movie
          </h2>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white/90">
            Feature Film
          </span>
        </div>
      </div>

      <!-- Form Content -->
      <div class="px-6 py-6 sm:px-8 sm:py-8">
        <form @submit.prevent="submitForm" class="space-y-8">
          <!-- Main Movie Info Section -->
          <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
              <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
              Movie Information
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <!-- Title -->
              <div class="space-y-2 md:col-span-2 lg:col-span-3">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Movie Title <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <input id="title" v-model="form.title" type="text" required
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="The Great Adventure">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Description -->
              <div class="space-y-2 md:col-span-2 lg:col-span-3">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Description
                </label>
                <textarea id="description" v-model="form.description" rows="4"
                  class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                  placeholder="Tell viewers about this movie..."></textarea>
              </div>

              <!-- Genre -->
              <div class="space-y-2">
                <label for="genre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Genre
                </label>
                <div class="relative">
                  <input id="genre" v-model="form.genre" type="text"
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="Action, Comedy">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Director -->
              <div class="space-y-2">
                <label for="director" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Director
                </label>
                <div class="relative">
                  <input id="director" v-model="form.director" type="text"
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="Director's Name">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Duration -->
              <div class="space-y-2">
                <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Duration
                </label>
                <div class="relative">
                  <input id="duration" v-model="form.duration" type="text"
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="2h 30m">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Media URLs Section -->
          <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
              <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
              </svg>
              Media URLs
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Poster URL -->
              <div class="space-y-2">
                <label for="poster" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Poster URL
                </label>
                <div class="relative">
                  <input id="poster" v-model="form.poster" type="url"
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="https://example.com/poster.jpg">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                </div>
                <div v-if="form.poster" class="mt-2">
                  <div class="text-xs text-gray-500 dark:text-gray-400">Preview:</div>
                  <img :src="form.poster" alt="Poster preview" class="mt-1 h-20 w-auto rounded border border-gray-200 dark:border-gray-700 object-cover">
                </div>
              </div>

              <!-- Cover Image URL -->
              <div class="space-y-2">
                <label for="cover_img" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Cover Image URL
                </label>
                <div class="relative">
                  <input id="cover_img" v-model="form.cover_img" type="url"
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="https://example.com/cover.jpg">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                </div>
                <div v-if="form.cover_img" class="mt-2">
                  <div class="text-xs text-gray-500 dark:text-gray-400">Preview:</div>
                  <img :src="form.cover_img" alt="Cover preview" class="mt-1 h-20 w-auto rounded border border-gray-200 dark:border-gray-700 object-cover">
                </div>
              </div>

              <!-- Movie URL -->
              <div class="space-y-2">
                <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Movie URL <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <input id="url" v-model="form.url" type="url" required
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="https://example.com/movie.mp4">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Dash URL -->
              <div class="space-y-2">
                <label for="dash_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Dash URL
                </label>
                <div class="relative">
                  <input id="dash_url" v-model="form.dash_url" type="url"
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="https://example.com/manifest.mpd">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- HLS URL -->
              <div class="space-y-2">
                <label for="hls_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  HLS URL
                </label>
                <div class="relative">
                  <input id="hls_url" v-model="form.hls_url" type="url"
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="https://example.com/playlist.m3u8">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <div class="space-y-2">
                <label for="title_img" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Title Image URL
                </label>
                <div class="relative">
                  <input id="title_img" v-model="form.title_img" type="url"
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="https://example.com/title_image.jpg">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Metadata Section -->
          <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
              <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
              </svg>
              Metadata
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <!-- PPV Rate -->
              <div class="space-y-2">
                <label for="ppv_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  PPV Rate
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 dark:text-gray-400">₹</span>
                  </div>
                  <input id="ppv_amount" v-model="form.ppv_amount" type="text"
                    class="block w-full pl-8 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="0.00 or Free">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 dark:text-gray-400 text-sm">INR</span>
                  </div>
                </div>
              </div>

              <!-- Status -->
              <div class="space-y-2">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Status <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <select id="status" v-model="form.status" required
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200 appearance-none">
                    <option disabled value="">Select status</option>
                    <option value="Scheduled">Scheduled</option>
                    <option value="Published">Published</option>
                    <option value="Draft">Draft</option>
                  </select>
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Create Date -->
              <div class="space-y-2">
                <label for="upload_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Create Date
                </label>
                <div class="relative">
                  <input id="upload_date" v-model="form.create_date" type="date"
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Release Date -->
              <div class="space-y-2">
                <label for="release_on" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Release Date
                </label>
                <div class="relative">
                  <input id="release_on" v-model="form.release_on" type="date"
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Boolean Options -->
          <div class="attributes-section pt-8 border-t border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
              <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
              </svg>
              Movie Attributes
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
              <label v-for="(label, key) in booleanFields" :key="key"
                class="checkbox-label flex items-start space-x-3 cursor-pointer p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <div class="flex items-center h-5">
                  <input type="checkbox" :id="`checkbox-${key}`" v-model="form[key]" class="sr-only peer">
                  <span class="custom-checkbox w-5 h-5 rounded border flex items-center justify-center
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
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300 select-none group-hover:text-gray-900 dark:group-hover:text-white transition-colors">
                  {{ label }}
                </div>
              </label>
            </div>
          </div>

          <div class="attributes-section pt-8 border-t border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
              <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
              </svg>
              Notification
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
              <label 
                class="checkbox-label flex items-start space-x-3 cursor-pointer p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <div class="flex items-center h-5">
                  <input type="checkbox" :id="checkbox" v-model="form.notification" class="sr-only peer">
                  <span class="custom-checkbox w-5 h-5 rounded border flex items-center justify-center
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
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300 select-none group-hover:text-gray-900 dark:group-hover:text-white transition-colors">
                  Notification
                </div>
              </label>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="pt-8 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
            <button type="button" @click="resetForm"
              class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
              Reset Form
            </button>
            <button type="submit"
              class="px-6 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-950 disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-200 flex justify-center items-center space-x-2"
              :disabled="loading">
              <span v-if="!loading">Submit Movie</span>
              <span v-else class="loading-spinner w-5 h-5 border-2 border-white/40 border-t-white rounded-full animate-spin"></span>
              <svg v-if="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
              </svg>
            </button>
          </div>

          <!-- Success/Error Message -->
          <div v-if="message" class="mt-6 p-4 rounded-lg text-sm font-medium flex items-start" :class="{
            'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-800': !message.startsWith('Failed'),
            'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800': message.startsWith('Failed')
          }">
            <svg v-if="!message.startsWith('Failed')" class="h-5 w-5 mr-2 text-green-500 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <svg v-else class="h-5 w-5 mr-2 text-red-500 dark:text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ message }}</span>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import axios from 'axios'

const getInitialFormState = () => ({
  title: '', genre: '', director: '', duration: '', description: '', ppv_amount: '',
  poster: '', cover_img: '', 
  url: '',  // Prefilled Movie URL
  dash_url: '',  // Prefilled Dash URL
  hls_url: '', trailer: '',
  title_img:'',
  release_on: '', create_date: '', status: '', notification: true,
  isProtected: false, isBollywood: false, isCompleted: false, isDocumentary: false,
  isAgeRestricted: false, isDubbed: false, isEnable: true, isHollywood: false,
  isKorean: false, isMizo: false, isPayPerView: false, isPremium: false,
  isSeason: false, isSubtitle: false,
  views: 0,
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
