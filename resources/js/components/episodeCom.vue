<template>
  <div class="max-w-10xl px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-800 transition-all duration-300">
      <!-- Form Header -->
      <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 px-6 py-4 sm:px-8">
        <div class="flex items-center justify-between">
          <h2 class="text-2xl font-bold text-white tracking-tight flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            Add New Episode
          </h2>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white/90">
            TV Series
          </span>
        </div>
      </div>

      <!-- Form Content -->
      <div class="px-6 py-6 sm:px-8 sm:py-8">
        <form @submit.prevent="submitForm" class="space-y-8">
          <!-- Main Episode Info Section -->
          <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
              <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
              Episode Information
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <!-- Title -->
              <div class="space-y-2">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Episode Title <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <input id="title" v-model="form.title" type="text" required
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="The Journey Begins">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Episode Identifier -->
              <div class="space-y-2">
                <label for="txt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Episode Identifier <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <input id="txt" v-model="form.txt" type="text" required
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="S1 E1">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- PPV Amount -->
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

              <!-- Description -->
              <div class="space-y-2 md:col-span-2 lg:col-span-3">
                <label for="desc" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Episode Description
                </label>
                <textarea id="desc" v-model="form.desc" rows="4"
                  class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                  placeholder="Tell viewers about this episode..."></textarea>
              </div>

              <!-- Token -->
              <div class="space-y-2 md:col-span-2 lg:col-span-3">
                <label for="token" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Episode Token
                </label>
                <textarea id="token" v-model="form.token" rows="3"
                  class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200 font-mono text-sm"
                  placeholder="Enter token data..."></textarea>
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
              <!-- Cover Image -->
              <div class="space-y-2">
                <label for="img" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Cover Image URL
                </label>
                <div class="relative">
                  <input id="img" v-model="form.img" type="url"
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="https://example.com/cover.jpg">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                </div>
                <div v-if="form.img" class="mt-2">
                  <div class="text-xs text-gray-500 dark:text-gray-400">Preview:</div>
                  <img :src="form.img" alt="Cover preview" class="mt-1 h-20 w-auto rounded border border-gray-200 dark:border-gray-700 object-cover">
                </div>
              </div>

              <!-- Video URL -->
              <div class="space-y-2">
                <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Video URL <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <input id="url" v-model="form.url" type="url" required
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                    placeholder="https://example.com/video.mp4">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- DASH URL -->
              <div class="space-y-2">
                <label for="dash_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  DASH URL
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
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Search Section for Show/Season -->
          <div class="search-section pt-8 border-t border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
              Associate with Show/Season
            </h3>
            
            <div v-if="selectedItemInfoText" class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800 flex justify-between items-center">
              <div class="flex items-center">
                <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="text-sm text-blue-700 dark:text-blue-300">{{ selectedItemInfoText }}</span>
              </div>
              <button @click="clearSelectedItem" type="button" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 text-xs font-medium p-1 rounded hover:bg-blue-100 dark:hover:bg-blue-800/30 transition-colors">
                Clear
              </button>
            </div>
            
            <div class="mb-6">
              <div class="flex flex-col sm:flex-row gap-4 mb-3">
                <div class="relative flex-grow">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></div>
                  <input type="text" v-model="search" placeholder="Search by title to find Show..." @keyup.enter="performSearch"
                    class="block w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"/>
                </div>
                <button @click="performSearch" :disabled="searchLoading" type="button"
                  class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-medium rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                  <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                  <span>Search</span>
                </button>
              </div>

              <div v-if="searchLoading" class="flex justify-center items-center py-12">
                <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-blue-500"></div>
              </div>

              <div v-if="!searchLoading">
                <div v-if="hasSearchedAtLeastOnce && movies.length === 0 && search.trim() !== ''" class="text-center py-4 text-gray-500 dark:text-gray-400">
                  No items found matching "{{ search }}"
                </div>
                <!-- === MODIFIED: Search Results List with Season Drill-down === -->
                <ul v-if="movies.length > 0" class="space-y-3 max-h-96 overflow-y-auto mt-4 border border-gray-200 dark:border-gray-700 rounded-lg p-3 bg-gray-50 dark:bg-gray-900/30 custom-scrollbar">
                  <li v-for="movie in filteredMovies" :key="movie.id" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden border border-gray-200 dark:border-gray-700 group">
                    
                    <!-- Movie/Show Title Row -->
                    <button type="button" class="w-full text-left" @click="toggleSeasons(movie)">
                      <div class="flex items-center justify-between p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex items-center space-x-3 min-w-0">
                          <div class="w-10 h-10 flex-shrink-0 rounded-lg bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                          </div>
                          <div class="min-w-0">
                            <p class="font-medium truncate text-gray-800 dark:text-gray-100">{{ movie.title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">Num: {{ movie.num }} • ID: {{ movie.id }}</p>
                          </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 transition-transform duration-300" :class="{'rotate-90': movie.showSeasons}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                      </div>
                    </button>
                    
                    <!-- NEW: Collapsible Season List -->
                    <div v-if="movie.showSeasons" class="bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                      <div v-if="movie.seasonsLoading" class="text-center py-4 text-sm text-gray-500">Loading seasons...</div>
                      <div v-else-if="!movie.seasons || movie.seasons.length === 0" class="text-center py-4 text-sm text-gray-500">No seasons found.</div>
                      <ul v-else class="py-2 px-3 space-y-1">
                        <li v-for="season in movie.seasons" :key="season.id">
                          <button type="button" class="w-full text-left p-2 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors" @click="selectSeason(movie, season)">
                            <div class="flex items-center space-x-2">
                               <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8"></path></svg>
                               <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ season.txt }}</span>
                               <span class="text-xs text-gray-400 dark:text-gray-500">(ID: {{ season.id }})</span>
                            </div>
                          </button>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Metadata Section -->
          <div class="space-y-6 pt-8 border-t border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
              <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
              </svg>
              Metadata
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <!-- === MODIFIED: This entire block is now conditional === -->
              <!-- It will only appear AFTER a season is selected from the search results. -->
              <div v-if="form.season_id" class="space-y-2">
                <label for="season_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Season ID <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <input id="season_id" v-model="form.season_id" type="text"
                    class="block w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200 cursor-not-allowed"
                    placeholder="Select a Season to populate">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
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
                <label for="create_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Create Date
                </label>
                <div class="relative">
                  <input id="create_date" v-model="form.create_date" type="date"
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
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
              </svg>
              Episode Attributes
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

          <!-- Form Actions -->
          <div class="pt-8 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
            <button type="button" @click="resetForm"
              class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
              Reset Form
            </button>
            <button type="submit"
              class="px-6 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-950 disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-200 flex justify-center items-center space-x-2"
              :disabled="formSubmitting">
              <span v-if="!formSubmitting">Submit Episode</span>
              <span v-else class="loading-spinner w-5 h-5 border-2 border-white/40 border-t-white rounded-full animate-spin"></span>
              <svg v-if="!formSubmitting" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
import { ref, reactive, computed, onMounted } from 'vue'
import axios from 'axios'
import { db } from '@/firebase'; // Make sure this path is correct for your project
import { collection, getDocs } from 'firebase/firestore';

const getInitialFormState = () => ({
  title: '',
  desc: '',
  ppv_amount: '',
  season_id: '', 
  movie_id: '', 
  txt: '',
  img: '',
  url: '',  // Prefilled Movie URL
  dash_url: '',  // Prefilled Dash URL
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
const searchLoading = ref(false);
const hasSearchedAtLeastOnce = ref(false);
const selectedItemInfoText = ref('');
const sortOrder = ref('asc'); 

// --- MODIFIED: fetchMovies now fetches only the main movie/show data ---
const fetchMovies = async (query = '') => {
  searchLoading.value = true;
  movies.value = [];
  try {
    const response = await axios.get(route('proxy.get'), { 
      params: { endpoint:'search', q: query, age_restriction: true, is_enable: false }
    });
    const results = Array.isArray(response.data) 
      ? response.data 
      : (response.data?.data && Array.isArray(response.data.data) ? response.data.data : []);
    
    // Add properties needed for the UI (showSeasons, seasonsLoading)
    movies.value = results
      .filter(movie => movie && typeof movie.id !== 'undefined' && typeof movie.num !== 'undefined')
      .map(movie => ({
        ...movie,
        seasons: [], // Initialize seasons array
        showSeasons: false, // Control visibility of the season list
        seasonsLoading: false, // Show a loading indicator for seasons
      }));

  } catch (fetchError) {
    console.error('Failed to fetch movies:', fetchError);
    movies.value = []; 
    message.value = `Search failed: ${fetchError.message || 'Network error'}`;
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
  return [...movies.value].sort((a, b) => {
    const titleA = String(a.title || '').toLowerCase();
    const titleB = String(b.title || '').toLowerCase();
    return sortOrder.value === 'asc' ? titleA.localeCompare(titleB) : titleB.localeCompare(titleA);
  });
});

// --- NEW: Function to toggle season visibility and fetch data ---
const toggleSeasons = async (movie) => {
  // Toggle visibility
  movie.showSeasons = !movie.showSeasons;

  // Fetch seasons only if they haven't been fetched yet and the list is being opened
  if (movie.showSeasons && movie.seasons.length === 0) {
    movie.seasonsLoading = true;
    try {
      const qSnap = await getDocs(collection(db, `movie/${movie.id}/season`));
      movie.seasons = qSnap.docs.map(d => ({
        id: d.id,
        ...(d.data()),
        txt: d.data().txt || d.data().title || `Season ${d.id.slice(-2)}`,
      })).sort((a, b) => (a.txt || '').localeCompare(b.txt || '', undefined, { numeric: true }));
    } catch (err) {
      console.error(`Error fetching seasons for movie ${movie.id}:`, err);
      movie.seasons = []; // Ensure it's an empty array on error
    } finally {
      movie.seasonsLoading = false;
    }
  }
};

// --- MODIFIED: selectSeason now finalizes the selection ---
const selectSeason = (movie, season) => {
  if (!movie || !season) {
    message.value = "Error: Invalid movie or season selected.";
    return;
  }
  
  // Populate the form fields
  form.movie_id = movie.num;
  form.season_id = season.id;
  
  // Update the feedback text
  selectedItemInfoText.value = `Associated with: ${movie.title} / ${season.txt}`;
  
  // Clear the search results to clean up the UI
  movies.value = []; 
  hasSearchedAtLeastOnce.value = false; 
  search.value = '';
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

    form.url = form.url.replace(/^.*?\.net/, "https://zostream-cdn-edcdf4gbdjeegugm.z03.azurefd.net");
    form.dash_url = form.dash_url.replace(/^.*?\.net/, "https://zostream-cdn-edcdf4gbdjeegugm.z03.azurefd.net");
    form.hls_url = form.hls_url.replace(/^.*?\.net/, "https://zostream-cdn-edcdf4gbdjeegugm.z03.azurefd.net");

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

// Always log the payload that was sent
console.log("Request payload:", JSON.stringify(payload, null, 2));

if (res.data.status === 'success') {
  message.value = 'Episode added successfully!';
  console.log("Server response:", res.data);
  
  // Reset form while preserving token
  const preservedToken = form.token;
  Object.assign(form, getInitialFormState());
  form.token = preservedToken;
  form.create_date = new Date().toISOString().split('T')[0];
  clearSelectedItem();
} else {
  error.value = res.data.message || 'Server processing error.';
  console.error("Server Error:", {
    status: res.status,
    statusText: res.statusText,
    data: res.data,
    headers: res.headers,
    request: res.request
  });
}

} catch (err) {
  if (err.response) {
    // The request was made and the server responded with a status code
    error.value = err.response.data.message || `Server error: ${err.response.status}`;
    console.error("Server Response Error:", {
      status: err.response.status,
      statusText: err.response.statusText,
      data: err.response.data,
      config: err.response.config
    });
  } else if (err.request) {
    // The request was made but no response was received
    error.value = 'No response from server. Check network or server status.';
    console.error("Network Error:", {
      message: err.message,
      request: err.request
    });
  } else {
    // Something happened in setting up the request
    error.value = err.message || 'An unexpected error occurred.';
    console.error("Request Setup Error:", {
      message: err.message,
      stack: err.stack
    });
  }
  message.value = `Failed: ${error.value}`;
} finally {
  formSubmitting.value = false;
}
}

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