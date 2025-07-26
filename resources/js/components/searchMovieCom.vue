<template>
    <div class="p-4 min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
        <div class="overflow-x-auto sm:overflow-visible">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Movie Collection</h1>
            </div>

            <div class="mb-6">
                <div class="flex flex-col sm:flex-row gap-3 mb-3">
                    <div class="relative flex-grow">
                        <input type="text" v-model="search" placeholder="Enter movie title..."
                            @keyup.enter="performSearch"
                            class="w-full pl-4 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 transition-all duration-200 text-sm sm:text-base" />
                    </div>
                </div>
                <div class="flex justify-center">
                    <button @click="performSearch" :disabled="loading"
                        class="px-4 sm:px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed w-full sm:w-auto text-sm sm:text-base">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span>Search</span>
                    </button>
                </div>
            </div>

            <div v-if="loading && !showEditModal && !showDeleteConfirmModal"
                class="flex justify-center items-center py-12">
                <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-blue-500"></div>
            </div>

            <div v-else-if="!showEditModal && !showDeleteConfirmModal">
                <div v-if="!hasSearchedAtLeastOnce" class="text-center py-12">
                    <div class="mx-auto w-20 h-20 sm:w-24 sm:h-24 text-gray-400 dark:text-gray-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-medium text-gray-700 dark:text-gray-300">Find Your Favorite
                        Movies</h3>
                    <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mt-1">Enter a movie title and click
                        the search button to begin.</p>
                </div>
                <div v-else-if="hasSearchedAtLeastOnce && filteredMovies.length === 0" class="text-center py-12">
                    <div class="mx-auto w-20 h-20 sm:w-24 sm:h-24 text-gray-400 dark:text-gray-500 mb-4">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-medium text-gray-700 dark:text-gray-300">No movies found</h3>
                    <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mt-1">Try adjusting your search
                        query or check for typos.</p>
                </div>
                <ul v-else-if="hasSearchedAtLeastOnce && filteredMovies.length > 0" class="space-y-2 min-w-0">
                    <li v-for="movie in filteredMovies" :key="movie.id"
                        class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div
                            class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-3 sm:p-4 gap-2 sm:gap-0">
                            <!-- Left side: Icon and Title (clickable to expand) -->
                            <div class="flex items-center space-x-3 min-w-0 flex-grow cursor-pointer"
                                @click="toggleMovie(movie)">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 flex-shrink-0 rounded-lg bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium truncate text-sm sm:text-base">{{ movie.title }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-mono truncate sm:hidden">{{
                            movie.id }}</p>
                                </div>
                            </div>

                            <div
                                class="hidden sm:block text-sm text-gray-500 dark:text-gray-400 font-mono mx-2 truncate">
                                {{ movie.id }}
                            </div>

                            <!-- Middle: Status Badge -->
                            <div class="flex-shrink-0 sm:mx-2" v-if="movie.status">
                                <span :class="getStatusClass(movie.status)"
                                    class="px-2 py-0.5 sm:px-2.5 sm:py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize">
                                    {{ movie.status }}
                                </span>
                            </div>

                            <!-- Right side: Action Buttons -->
                            <div class="flex space-x-2 flex-shrink-0 w-full sm:w-auto justify-end sm:justify-normal">
                                <button
                                    class="px-2 py-1 sm:px-3 sm:py-1.5 text-xs sm:text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center space-x-1 disabled:opacity-70 disabled:cursor-wait"
                                    @click.stop="editMovie(movie)"
                                    :disabled="isFetchingEditItemDetails && editingItemContext?.id === movie.id && !editingItemContext?.seasonId">
                                    <svg v-if="isFetchingEditItemDetails && editingItemContext?.id === movie.id && !editingItemContext?.seasonId"
                                        class="animate-spin h-3 w-3 sm:h-4 sm:w-4 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    <svg v-else class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    <span>Edit</span>
                                </button>
                                <button
                                    class="px-2 py-1 sm:px-3 sm:py-1.5 text-xs sm:text-sm bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200 flex items-center space-x-1"
                                    @click.stop="openDeleteConfirmation(movie)">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    <span>Delete</span>
                                </button>
                            </div>
                        </div>

                        <div v-if="expandedMovie === movie.id && movie.isSeason"
                            class="border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30 transition-all duration-200">
                            <div v-for="season in movie.seasons || []" :key="season.id"
                                class="px-3 sm:px-4 py-2 sm:py-3">
                                <div class="flex items-center justify-between font-medium text-xs sm:text-sm">
                                    <div class="flex items-center space-x-2 cursor-pointer hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-150"
                                        @click="toggleSeasonEpisodes(movie, season)">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 transform transition-transform duration-200"
                                            :class="{ 'rotate-90': season.showEpisodes }" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        <span class="truncate max-w-[120px] sm:max-w-none">{{ season.txt }}</span>
                                        <span
                                            class="text-xs text-gray-500 dark:text-gray-400 font-mono hidden sm:inline">{{
                            season.id }}</span>
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ season.episodes.length }}
                                        episode{{
                            season.episodes.length !== 1 ? 's' : '' }}</span>
                                </div>
                                <ul v-if="season.showEpisodes"
                                    class="ml-4 sm:ml-6 mt-1 sm:mt-2 space-y-1 sm:space-y-2 animate-fadeIn">
                                    <li v-for="ep in season.episodes" :key="ep.id"
                                        class="flex items-center justify-between py-1 sm:py-2 px-2 sm:px-3 -mx-2 sm:-mx-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                        <span class="text-xs sm:text-sm truncate max-w-[100px] sm:max-w-none">{{ ep.txt
                            || 'Untitled Episode' }}</span>
                                        <span
                                            class="text-xs text-gray-500 dark:text-gray-400 font-mono ml-2 sm:ml-4 hidden sm:inline">{{
                            ep.id }}</span>
                                        <!-- Middle: Status Badge -->
                                        <div class="flex-shrink-0 mx-1 sm:mx-2" v-if="ep.status">
                                            <span :class="getStatusClass(ep.status)"
                                                class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize">
                                                {{ ep.status }}
                                            </span>
                                        </div>
                                        <div class="flex space-x-1 sm:space-x-2 flex-shrink-0">
                                            <button
                                                class="px-1.5 py-0.5 sm:px-2 sm:py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition-colors duration-200 flex items-center space-x-1 disabled:opacity-70 disabled:cursor-wait"
                                                @click.stop="editMovie(ep, movie.id, season.id)"
                                                :disabled="isFetchingEditItemDetails && editingItemContext?.id === ep.id && editingItemContext?.seasonId === season.id">
                                                <svg v-if="isFetchingEditItemDetails && editingItemContext?.id === ep.id && editingItemContext?.seasonId === season.id"
                                                    class="animate-spin h-2.5 w-2.5 sm:h-3 sm:w-3 text-white"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4">
                                                    </circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                <svg v-else class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                <span class="hidden sm:inline">Edit</span>
                                            </button>
                                            <button
                                                class="px-1.5 py-0.5 sm:px-2 sm:py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition-colors duration-200 flex items-center space-x-1"
                                                @click.stop="openDeleteConfirmation(ep, movie.id, season.id)">
                                                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                <span class="hidden sm:inline">Delete</span>
                                            </button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Edit Modal (remains the same, with v-if="showEditModal") -->
        <div v-if="showEditModal"
     class="fixed inset-0 bg-gray-600 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75 transition-opacity duration-300 ease-in-out flex items-center justify-center p-4 z-[100]"
     @click.self="closeEditModal">

     <!-- Wider Movie Edit Form -->
     <div v-if="editingItem && !editingItem.seasonId"
          class="form-container bg-white dark:bg-gray-950 text-gray-800 dark:text-gray-100 p-6 sm:p-8 md:p-10 rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-y-auto">
                <!-- ... Movie form content ... -->
                <h2
                    class="text-2xl sm:text-3xl font-bold mb-8 text-center sm:text-left text-gray-900 dark:text-white tracking-tight">
                    Update Movie</h2>
                <form @submit.prevent="submitForm" class="space-y-8">
                    <!-- Movie fields here -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
                        <div class="form-group sm:col-span-2 lg:col-span-3"><label for="movie-title"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Movie
                                Title</label><input id="movie-title" v-model="editForm.title" type="text"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                placeholder="Enter movie title"></div>
                        <div class="form-group sm:col-span-2 lg:col-span-3"><label for="movie-description"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Description</label><textarea
                                id="movie-description" v-model="editForm.description"
                                class="block w-full min-h-[8rem] rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                rows="4" placeholder="Provide a compelling movie description..."></textarea></div>
                        <div class="form-group"><label for="movie-genre"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Genre</label><input
                                id="movie-genre" v-model="editForm.genre" type="text"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                placeholder="e.g., Action, Comedy"></div>
                        <div class="form-group"><label for="movie-director"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Director</label><input
                                id="movie-director" v-model="editForm.director" type="text"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                placeholder="Director's Name"></div>
                        <div class="form-group"><label for="movie-duration"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Duration</label><input
                                id="movie-duration" v-model="editForm.duration" type="text"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                placeholder="e.g., 2h 30m"></div>
                        <div class="form-group"><label for="movie-ppv_amount"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">PPV
                                rate</label><input id="movie-ppv_amount" v-model="editForm.ppv_amount" type="text"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                placeholder="e.g., 200 or Free"></div>
                        <div class="form-group"><label for="movie-status"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Status</label><select
                                id="movie-status" v-model="editForm.status"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900">
                                <option disabled value="">Select status</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Published">Published</option>
                                <option value="Draft">Draft</option>
                            </select></div>
                        <div class="form-group"><label for="movie-upload_date"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Create
                                Date</label><input id="movie-upload_date" v-model="editForm.create_date" type="date"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900 dark:[color-scheme:dark]">
                        </div>
                        <div class="form-group"><label for="movie-poster"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Poster
                                URL</label><input id="movie-poster" v-model="editForm.poster" type="url"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                placeholder="https://example.com/poster.jpg"></div>
                        <div class="form-group"><label for="movie-cover_img"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Cover
                                Image
                                URL</label><input id="movie-cover_img" v-model="editForm.cover_img" type="url"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                placeholder="https://example.com/cover.jpg"></div>
                        <div class="form-group"><label for="movie-release_on"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Release
                                Date</label><input id="movie-release_on" v-model="editForm.release_on" type="date"
                                class="block w-full rounded-lg border-0 py-2 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900 dark:[color-scheme:dark]">
                        </div>
                            <!-- Movie URL with Play Button -->
                            <div class="form-group">
                                <label for="movie-url"
                                    class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">
                                    Movie URL
                                </label>
                                <div class="flex items-center gap-2">
                                    <input id="movie-url" v-model="editForm.url" type="url"
                                        class="flex-1 rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                        placeholder="https://example.com/movie.mp4">
                                    <button @click="showPlayer = true" :disabled="!editForm.url"
                                        class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                        title="Preview movie">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- DRM URL with Play Button -->
                            <div class="form-group">
                                <label for="movie-dash_url"
                                    class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">
                                    DRM URL
                                </label>
                                <div class="flex items-center gap-2">
                                    <input id="movie-dash_url" v-model="editForm.dash_url" type="url"
                                        class="flex-1 rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                        placeholder="https://example.com/movie.mpd">
                                    <button @click="showPlayer = true" :disabled="!editForm.dash_url"
                                        class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                        title="Preview DRM content">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        <div class="form-group"><label for="title_img"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Title
                                Image
                                URL</label><input id="title_img" v-model="editForm.title_img" type="url"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                placeholder="https://example.com/title.jpg"></div>
                    </div>
                    <div class="attributes-section pt-8 border-t border-gray-200 dark:border-gray-800">
                        <h3 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">Movie Attributes</h3>
                        <div
                            class="checkboxes-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-5">
                            <label v-for="(label, key) in movieBooleanFields" :key="key"
                                class="checkbox-label flex items-center space-x-3 cursor-pointer group">
                                <input type="checkbox" :id="`movie-checkbox-${key}`" v-model="editForm[key]"
                                    class="sr-only peer">
                                <span
                                    class="custom-checkbox w-5 h-5 rounded-md border flex items-center justify-center border-gray-400 dark:border-gray-600 bg-white dark:bg-gray-800 group-hover:border-gray-500 dark:group-hover:border-gray-500 peer-checked:bg-blue-600 peer-checked:border-blue-600 dark:peer-checked:bg-blue-500 dark:peer-checked:border-blue-500 peer-focus-visible:ring-2 peer-focus-visible:ring-offset-2 peer-focus-visible:ring-blue-500 dark:peer-focus-visible:ring-offset-gray-950 transition-all duration-150 ease-in-out"><svg
                                        class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-150"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5"
                                            d="M5 13l4 4L19 7">
                                        </path>
                                    </svg></span>
                                <span
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300 select-none group-hover:text-gray-900 dark:group-hover:text-white transition-colors">{{
                            label }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="pt-8 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                        <button type="button" @click="closeEditModal"
                            class="cancel-button w-full sm:w-auto py-3 px-8 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 dark:focus:ring-offset-gray-950 transition-all duration-150 ease-in-out">Cancel</button>
                        <button type="submit"
                            class="submit-button w-full sm:w-auto py-3 px-8 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-950 disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-150 ease-in-out flex justify-center items-center"
                            :disabled="modalLoading">
                            <span v-if="!modalLoading">Update Movie</span>
                            <span v-else
                                class="loading-spinner w-5 h-5 border-2 border-white/40 border-t-white rounded-full animate-spin"></span>
                        </button>
                    </div>
                    <div v-if="modalMessage" class="message mt-6 p-4 rounded-lg text-sm font-medium text-center"
                        :class="{ 'bg-green-50 dark:bg-green-700/20 text-green-700 dark:text-green-300 border border-green-300 dark:border-green-600/50': !modalMessage.startsWith('Failed'), 'bg-red-50 dark:bg-red-700/20 text-red-700 dark:text-red-300 border border-red-300 dark:border-red-600/50': modalMessage.startsWith('Failed') }">
                        {{ modalMessage }}</div>
                </form>
            </div>

            <!-- Episode Edit Form -->
            <div v-if="editingItem && editingItem.seasonId"
                class="form-container bg-white dark:bg-gray-950 text-gray-800 dark:text-gray-100 p-6 sm:p-8 md:p-10 rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-y-auto">
                <!-- ... Episode form content ... -->
                <h2
                    class="text-2xl sm:text-3xl font-bold mb-8 text-center sm:text-left text-gray-900 dark:text-white tracking-tight">
                    Update Episode</h2>
                <form @submit.prevent="submitForm" class="space-y-8">
                    <!-- Episode fields here -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
                        <div class="form-group"><label for="ep-title"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Episode
                                Title</label><input id="ep-title" v-model="editForm.title" type="text"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                placeholder="Enter episode title"></div>
                        <div class="form-group sm:col-span-2 lg:col-span-3"><label for="ep-desc"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Episode
                                Description</label><textarea id="ep-desc" v-model="editForm.desc"
                                class="block w-full min-h-[8rem] rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                rows="4" placeholder="Provide episode details..."></textarea></div>
                        <div class="form-group"><label for="ep-txt"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Episode
                                Identifier
                                (e.g., S1 E1)</label><input id="ep-txt" v-model="editForm.txt" type="text"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                placeholder="S1 E1"></div>
                        <div class="form-group"><label for="ep-season_id"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Season
                                ID</label><input id="ep-season_id" v-model="editForm.season_id" type="text"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                placeholder="Enter Season ID" readonly></div>
                        <div class="form-group"><label for="ep-ppv_amount"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">PPV
                                Rate</label><input id="ep-ppv_amount" v-model="editForm.ppv_amount" type="text"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                placeholder="e.g., 200 or Free"></div>
                        <div class="form-group"><label for="ep-img"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Cover
                                Image
                                URL</label><input id="ep-img" v-model="editForm.img" type="url"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                placeholder="https://example.com/image.jpg"></div>
                            <!-- Video URL with Play Button -->
                            <div class="form-group">
                                <label for="ep-url"
                                    class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">
                                    Video URL
                                </label>
                                <div class="relative flex items-center gap-2">
                                    <input id="ep-url" v-model="editForm.url" type="url"
                                        class="block flex-1 rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                        placeholder="https://example.com/episode.mp4">
                                    <button @click="showPlayer = true" :disabled="!editForm.url"
                                        class="flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                        title="Preview video">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- DRM URL with Play Button -->
                            <div class="form-group">
                                <label for="ep-dash_url"
                                    class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">
                                    DRM URL
                                </label>
                                <div class="relative flex items-center gap-2">
                                    <input id="ep-dash_url" v-model="editForm.dash_url" type="url"
                                        class="block flex-1 rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900"
                                        placeholder="https://example.com/episode.mpd">
                                    <button @click="showPlayer = true" :disabled="!editForm.dash_url"
                                        class="flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                        title="Preview DRM content">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        <div class="form-group"><label for="ep-status"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Status</label><select
                                id="ep-status" v-model="editForm.status"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900">
                                <option disabled value="">Select status</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Published">Published</option>
                                <option value="Draft">Draft</option>
                            </select></div>
                        <div class="form-group"><label for="ep-upload_date"
                                class="block text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 mb-1.5">Create
                                Date</label><input id="ep-upload_date" v-model="editForm.create_date" type="date"
                                class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:focus:ring-blue-500 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900 dark:[color-scheme:dark]">
                        </div>
                    </div>
                    <div class="attributes-section pt-8 border-t border-gray-200 dark:border-gray-800">
                        <h3 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">Episode Attributes</h3>
                        <div
                            class="checkboxes-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-5">
                            <label v-for="(label, key) in episodeBooleanFields" :key="key"
                                class="checkbox-label flex items-center space-x-3 cursor-pointer group">
                                <input type="checkbox" :id="`ep-checkbox-${key}`" v-model="editForm[key]"
                                    class="sr-only peer">
                                <span
                                    class="custom-checkbox w-5 h-5 rounded-md border flex items-center justify-center border-gray-400 dark:border-gray-600 bg-white dark:bg-gray-800 group-hover:border-gray-500 dark:group-hover:border-gray-500 peer-checked:bg-blue-600 peer-checked:border-blue-600 dark:peer-checked:bg-blue-500 dark:peer-checked:border-blue-500 peer-focus-visible:ring-2 peer-focus-visible:ring-offset-2 peer-focus-visible:ring-blue-500 dark:peer-focus-visible:ring-offset-gray-950 transition-all duration-150 ease-in-out"><svg
                                        class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-150"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5"
                                            d="M5 13l4 4L19 7">
                                        </path>
                                    </svg></span>
                                <span
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300 select-none group-hover:text-gray-900 dark:group-hover:text-white transition-colors">{{
                            label }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="pt-8 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                        <button type="button" @click="closeEditModal"
                            class="cancel-button w-full sm:w-auto py-3 px-8 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 dark:focus:ring-offset-gray-950 transition-all duration-150 ease-in-out">Cancel</button>
                        <button type="submit"
                            class="submit-button w-full sm:w-auto py-3 px-8 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-950 disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-150 ease-in-out flex justify-center items-center"
                            :disabled="modalLoading">
                            <span v-if="!modalLoading">Update Episode</span>
                            <span v-else
                                class="loading-spinner w-5 h-5 border-2 border-white/40 border-t-white rounded-full animate-spin"></span>
                        </button>
                    </div>
                    <div v-if="modalMessage" class="message mt-6 p-4 rounded-lg text-sm font-medium text-center"
                        :class="{ 'bg-green-50 dark:bg-green-700/20 text-green-700 dark:text-green-300 border border-green-300 dark:border-green-600/50': !modalMessage.startsWith('Failed'), 'bg-red-50 dark:bg-red-700/20 text-red-700 dark:text-red-300 border border-red-300 dark:border-red-600/50': modalMessage.startsWith('Failed') }">
                        {{ modalMessage }}</div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteConfirmModal"
            class="fixed inset-0 bg-gray-800 bg-opacity-75 transition-opacity duration-300 ease-in-out flex items-center justify-center p-4 z-[110]"
            @click.self="closeDeleteConfirmation">
            <div
                class="bg-white dark:bg-gray-900 rounded-lg shadow-xl p-6 sm:p-8 w-full max-w-md transform transition-all">
                <div class="text-center">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" stroke="currentColor" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                        Delete {{ itemToDelete?.type === 'episode' ? 'Episode' : 'Movie' }}
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Are you sure you want to delete "{{ itemToDelete?.titleOrTxt }}"? This action cannot be
                            undone.
                        </p>
                    </div>
                </div>
                <div v-if="deleteModalMessage" class="mt-4 p-3 rounded-md text-sm text-center" :class="{
                            'bg-green-50 dark:bg-green-700/20 text-green-700 dark:text-green-300 border border-green-300 dark:border-green-600/50': !deleteModalMessage.startsWith('Failed'),
                            'bg-red-50 dark:bg-red-700/20 text-red-700 dark:text-red-300 border border-red-300 dark:border-red-600/50': deleteModalMessage.startsWith('Failed')
                        }">
                    {{ deleteModalMessage }}
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <button @click="confirmDeleteItem" :disabled="isDeleting"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-900 sm:col-start-2 sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        <span v-if="!isDeleting">Confirm Delete</span>
                        <span v-else class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Deleting...
                        </span>
                    </button>
                    <button @click="closeDeleteConfirmation" :disabled="isDeleting"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 sm:mt-0 sm:col-start-1 sm:text-sm disabled:opacity-50">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
        <ShakaPlayer v-if="showPlayer" :videoUrl="videoUrl" @close="showPlayer = false" />
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { db } from '@/firebase'; // Used for toggleMovie, toggleSeasonEpisodes (local Firestore data)
import { collection, getDocs } from 'firebase/firestore';
import ShakaPlayer from '@/components/shakaPlayerCom.vue'
import { toast } from 'vue3-toastify';

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

const videoUrl = computed(() => editForm.url || editForm.dash_url)
const showPlayer = ref(false)

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
    isSubtitle: 'Has Subtitle', notification: 'Notification',
});

const episodeBooleanFields = ref({
    isProtected: 'Protected',
    isEnable: 'Enable',
    isPPV: 'Pay Per View', // Assuming this maps to an API field like isPayPerView or isPpv
    isPremium: 'Premium',
    notification: 'Notification',
});

const getInitialMovieForm = () => ({
    title: '', description: '', genre: '', notification: false, director: '', duration: '', title_img: '',
    ppv_amount: '', status: '', create_date: '', poster: '', cover_img: '',
    release_on: '', url: '', dash_url: '',
    ...Object.fromEntries(Object.keys(movieBooleanFields.value).map(key => [key, false]))
});

const getInitialEpisodeForm = () => ({
    title: '', desc: '', txt: '', season_id: '', ppv_amount: '', notification: false,
    img: '', url: '', dash_url: '', status: '', create_date: '',
    ...Object.fromEntries(Object.keys(episodeBooleanFields.value).map(key => [key, false]))
});

// --- Utility Functions ---
const formatDateForInput = (dateStringOrTimestamp) => {
    if (!dateStringOrTimestamp) return '';

    try {
        let year, month, day; // Target: year (number), month (1-12), day (number)

        if (typeof dateStringOrTimestamp === 'object' && dateStringOrTimestamp.seconds !== undefined && dateStringOrTimestamp.nanoseconds !== undefined) {
            // Firestore Timestamp (represents a point in time, UTC)
            const d = new Date(dateStringOrTimestamp.seconds * 1000);
            year = d.getUTCFullYear();
            month = d.getUTCMonth() + 1; // getUTCMonth is 0-indexed
            day = d.getUTCDate();
        } else if (typeof dateStringOrTimestamp === 'string') {
            // Attempt to parse "DD Month YYYY" format, e.g., "15 May 2025"
            const ddmmyyyyParts = dateStringOrTimestamp.match(/^(\d{1,2})\s+([A-Za-z]+)\s+(\d{4})$/);
            if (ddmmyyyyParts) {
                day = parseInt(ddmmyyyyParts[1], 10);
                const monthName = ddmmyyyyParts[2];
                year = parseInt(ddmmyyyyParts[3], 10);
                // Convert month name to 1-indexed number. Date.parse is good for this.
                // Create a temporary date like "May 1, 2000" to reliably get the month index.
                const tempMonthDate = new Date(Date.parse(monthName + " 1, 2000"));
                if (isNaN(tempMonthDate.valueOf())) throw new Error(`Invalid month name: ${monthName}`);
                month = tempMonthDate.getMonth() + 1; // getMonth is 0-indexed

                if (isNaN(day) || isNaN(month) || isNaN(year)) {
                    throw new Error(`Failed to parse DD Month YYYY: ${dateStringOrTimestamp}`);
                }
            } else {
                // Handle other string formats like "YYYY-MM-DD" or full ISO strings.
                const d = new Date(dateStringOrTimestamp);
                if (isNaN(d.valueOf())) {
                    throw new Error(`Invalid date string for new Date(): ${dateStringOrTimestamp}`);
                }

                // If the string was "YYYY-MM-DD" (date-only form), new Date() parses it as UTC midnight.
                // To preserve that specific date, use UTC getters.
                if (dateStringOrTimestamp.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    year = d.getUTCFullYear();
                    month = d.getUTCMonth() + 1;
                    day = d.getUTCDate();
                } else {
                    // For other valid date strings (e.g., full ISO with time, or other formats new Date understands),
                    // they might represent local time or specific UTC time.
                    // We'll take the date components as they are interpreted by the Date object.
                    // If it's a full ISO string with 'Z' or offset, it's UTC. If no offset, it's local.
                    // For display in a date input, typically the local date part is desired.
                    year = d.getFullYear();
                    month = d.getMonth() + 1;
                    day = d.getDate();
                }
            }
        } else if (typeof dateStringOrTimestamp === 'number') {
            // Assume it's a Unix timestamp in milliseconds (UTC)
            const d = new Date(dateStringOrTimestamp);
            year = d.getUTCFullYear();
            month = d.getUTCMonth() + 1;
            day = d.getUTCDate();
        } else {
            throw new Error(`Unsupported date input type: ${typeof dateStringOrTimestamp}`);
        }

        if (year === undefined || month === undefined || day === undefined) {
            throw new Error(`Date components not successfully parsed from: ${dateStringOrTimestamp}`);
        }

        // Format to YYYY-MM-DD
        return `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

    } catch (e) {
        console.error("Error in formatDateForInput with '", dateStringOrTimestamp, "':", e.message);
        return ''; // Return empty string on error, so the input field is blank.
    }
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
        console.log('Data:', response.data)
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
            const response = await axios.get(route('proxy.get'), {
                params: {
                    endpoint: `episode/${itemIdToFetch}`
                } ,
                headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
            });

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
            form.desc = itemDetails.desc || '';
            form.txt = itemDetails.txt || ''; // This might be for display, API might not have/use it
            form.season_id = pSeasonId || itemDetails.season_id || ''; // API should provide season_id for an episode
            form.ppv_amount = itemDetails.ppv_amount || itemDetails.ppvAmount || ''; // Check API field name
            form.status = itemDetails.status || '';
            form.create_date = formatDateForInput(itemDetails.create_date);

            const epUrlFields = { img: 'img', url: 'url', dash_url: 'dash_url' };
            for (const [formKey, detailKey] of Object.entries(epUrlFields)) {
                form[formKey] = itemDetails[detailKey] ? await decryptUrl(itemDetails[detailKey]) : '';
            }
            for (const key in episodeBooleanFields.value) {
                form[key] = !!itemDetails[key]; // Map API boolean fields
            }
        } else { // Movie
            form.title = itemDetails.title || '';
            form.description = itemDetails.description || '';
            form.title_img = itemDetails.title_img || '';
            form.genre = itemDetails.genre || '';
            form.director = itemDetails.director || '';
            form.duration = itemDetails.duration || '';
            form.ppv_amount = itemDetails.ppv_amount || itemDetails.ppvAmount || '';
            form.status = itemDetails.status || '';
            form.create_date = formatDateForInput(itemDetails.create_date || itemDetails.upload_date || itemDetails.createdAt);
            form.release_on = formatDateForInput(itemDetails.release_on || itemDetails.releaseDate);

            const movieUrlFields = { poster: 'poster', cover_img: 'cover_img', url: 'url', dash_url: 'dash_url', title_img: 'title_img' };
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
        const urlFields = ['url', 'dash_url'];
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

        console.log(`Submitting update to`, "Payload:", payload);
        await axios.put(route('proxy.put'), payload, {
            params:{
                endpoint: `${apiSegment}/${itemCtx.id}`
            },
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        toast.success(`${isEpisode ? 'Episode' : 'Movie'} updated successfully!`);
        modalMessage.value = `${isEpisode ? 'Episode' : 'Movie'} updated successfully!`;
        showEditModal.value = false;

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
        toast.error('Update submission failed:', err.config?.url, err.response || err);
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

        console.log(`Attempting to DELETE: ${itemCtx.type} with ID ${itemCtx.id} from URL`);

        await axios.delete(route('proxy.delete'),{
            params:{
                endpoint:`${apiDeleteSegment}/${itemCtx.id}`
            },

            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }});

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
