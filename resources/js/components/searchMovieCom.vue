<template>
    <div class="min-h-screen bg-gray-50 p-8 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
        <div class="overflow-x-auto sm:overflow-visible">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl dark:text-white">Movie Collection</h1>
            </div>

            <div class="mb-6">
                <div class="mb-3 flex flex-col gap-3 sm:flex-row">
                    <div class="relative flex-grow">
                        <input
                            type="text"
                            v-model="search"
                            placeholder="Enter movie title..."
                            @keyup.enter="performSearch"
                            class="w-full rounded-lg border border-gray-300 bg-white py-2 pr-4 pl-4 text-sm transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 sm:text-base dark:border-gray-700 dark:bg-gray-800 dark:focus:border-blue-600 dark:focus:ring-blue-600"
                        />
                    </div>
                </div>
                <div class="flex justify-center">
                    <button
                        @click="performSearch"
                        :disabled="loading"
                        class="flex w-full items-center justify-center space-x-2 rounded-lg bg-blue-600 px-4 py-2 text-sm text-white transition-colors duration-200 hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 sm:w-auto sm:px-6 sm:text-base"
                    >
                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span>Search</span>
                    </button>
                </div>
            </div>

            <div v-if="loading && !showEditModal && !showDeleteConfirmModal" class="flex items-center justify-center py-12">
                <div class="h-10 w-10 animate-spin rounded-full border-t-2 border-b-2 border-blue-500"></div>
            </div>

            <div v-else-if="!showEditModal && !showDeleteConfirmModal">
                <div v-if="!hasSearchedAtLeastOnce" class="py-12 text-center">
                    <div class="mx-auto mb-4 h-20 w-20 text-gray-400 sm:h-24 sm:w-24 dark:text-gray-500">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-full w-full"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                    </div>
                    <h3 class="text-base font-medium text-gray-700 sm:text-lg dark:text-gray-300">Find Your Favorite Movies</h3>
                    <p class="mt-1 text-sm text-gray-500 sm:text-base dark:text-gray-400">
                        Enter a movie title and click the search button to begin.
                    </p>
                </div>
                <div v-else-if="hasSearchedAtLeastOnce && filteredMovies.length === 0" class="py-12 text-center">
                    <div class="mx-auto mb-4 h-20 w-20 text-gray-400 sm:h-24 sm:w-24 dark:text-gray-500">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-medium text-gray-700 sm:text-lg dark:text-gray-300">No movies found</h3>
                    <p class="mt-1 text-sm text-gray-500 sm:text-base dark:text-gray-400">Try adjusting your search query or check for typos.</p>
                </div>
                <ul v-else-if="hasSearchedAtLeastOnce && filteredMovies.length > 0" class="min-w-0 space-y-2">
                    <li
                        v-for="movie in filteredMovies"
                        :key="movie.id"
                        class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition-shadow duration-200 hover:shadow-md sm:rounded-xl dark:border-gray-700 dark:bg-gray-800"
                    >
                        <div class="flex flex-col items-start justify-between gap-2 p-3 sm:flex-row sm:items-center sm:gap-0 sm:p-4">
                            <!-- Left side: Icon and Title (clickable to expand) -->
                            <div class="flex min-w-0 flex-grow cursor-pointer items-center space-x-3" @click="toggleMovie(movie)">
                                <div
                                    class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-blue-100 sm:h-10 sm:w-10 dark:bg-blue-900/50"
                                >
                                    <svg
                                        class="h-4 w-4 text-blue-600 sm:h-5 sm:w-5 dark:text-blue-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"
                                        ></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium sm:text-base">{{ movie.title }}</p>
                                    <p class="truncate font-mono text-xs text-gray-500 sm:hidden dark:text-gray-400">{{ movie.id }}</p>
                                </div>
                            </div>

                            <div class="mx-2 hidden truncate font-mono text-sm text-gray-500 sm:block dark:text-gray-400">
                                {{ movie.id }}
                            </div>

                            <!-- Middle: Status Badge -->
                            <div class="flex-shrink-0 sm:mx-2" v-if="movie.status">
                                <span
                                    :class="getStatusClass(movie.status)"
                                    class="inline-flex rounded-full px-2 py-0.5 text-xs leading-5 font-semibold capitalize sm:px-2.5 sm:py-1"
                                >
                                    {{ movie.status }}
                                </span>
                            </div>

                            <!-- Right side: Action Buttons -->
                            <div class="flex w-full flex-shrink-0 justify-end space-x-2 sm:w-auto sm:justify-normal">
                                <button
                                    class="flex items-center space-x-1 rounded-lg bg-blue-600 px-2 py-1 text-xs text-white transition-colors duration-200 hover:bg-blue-700 disabled:cursor-wait disabled:opacity-70 sm:px-3 sm:py-1.5 sm:text-sm"
                                    @click.stop="editMovie(movie)"
                                    :disabled="isFetchingEditItemDetails && editingItemContext?.id === movie.id && !editingItemContext?.seasonId"
                                >
                                    <svg
                                        v-if="isFetchingEditItemDetails && editingItemContext?.id === movie.id && !editingItemContext?.seasonId"
                                        class="h-3 w-3 animate-spin text-white sm:h-4 sm:w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                        ></path>
                                    </svg>
                                    <svg
                                        v-else
                                        class="h-3 w-3 sm:h-4 sm:w-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                        ></path>
                                    </svg>
                                    <span>Edit</span>
                                </button>
                                <button
                                    class="flex items-center space-x-1 rounded-lg bg-red-600 px-2 py-1 text-xs text-white transition-colors duration-200 hover:bg-red-700 sm:px-3 sm:py-1.5 sm:text-sm"
                                    @click.stop="openDeleteConfirmation(movie)"
                                >
                                    <svg
                                        class="h-3 w-3 sm:h-4 sm:w-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        ></path>
                                    </svg>
                                    <span>Delete</span>
                                </button>
                            </div>
                        </div>

                        <!-- Seasons and Episodes Section -->
                        <div
                            v-if="expandedMovie === movie.id && movie.isSeason"
                            class="border-t border-gray-200 bg-gray-50 transition-all duration-200 dark:border-gray-700 dark:bg-gray-700/30"
                        >
                            <!-- Loader for Seasons -->
                            <div v-if="loadingSeasonsFor.has(movie.id)" class="p-4 text-center">
                                <div class="mx-auto h-6 w-6 animate-spin rounded-full border-t-2 border-b-2 border-blue-500"></div>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Loading seasons...</p>
                            </div>

                            <!-- Message for no seasons found -->
                            <div
                                v-else-if="!movie.seasons || movie.seasons.length === 0"
                                class="p-4 text-center text-sm text-gray-500 dark:text-gray-400"
                            >
                                No seasons found for this series.
                            </div>

                            <!-- Render Seasons (only if not loading and seasons exist) -->
                            <div v-else v-for="season in movie.seasons" :key="season.id" class="px-3 py-2 sm:px-4 sm:py-3">
                                <div class="flex items-center justify-between text-xs font-medium sm:text-sm">
                                    <div
                                        class="flex cursor-pointer items-center space-x-2 transition-colors duration-150 hover:text-blue-500 dark:hover:text-blue-400"
                                        @click="toggleSeasonEpisodes(movie, season)"
                                    >
                                        <svg
                                            class="h-3 w-3 transform transition-transform duration-200 sm:h-4 sm:w-4"
                                            :class="{ 'rotate-90': season.showEpisodes }"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        <span class="max-w-[120px] truncate sm:max-w-none">{{ season.txt }}</span>
                                        <span class="hidden font-mono text-xs text-gray-500 sm:inline dark:text-gray-400">{{ season.id }}</span>
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400"
                                        >{{ season.episodes?.length || 0 }} episode{{ (season.episodes?.length || 0) !== 1 ? 's' : '' }}</span
                                    >
                                </div>
                                <ul v-if="season.showEpisodes" class="animate-fadeIn mt-1 ml-4 space-y-1 sm:mt-2 sm:ml-6 sm:space-y-2">
                                    <!-- Loader for Episodes -->
                                    <li v-if="loadingEpisodesFor.has(season.id)" class="py-2 text-center">
                                        <div class="mx-auto h-5 w-5 animate-spin rounded-full border-t-2 border-b-2 border-blue-500"></div>
                                    </li>

                                    <!-- Render Episodes (only if not loading) -->
                                    <template v-else>
                                        <li v-if="season.episodes.length === 0" class="py-2 text-xs text-gray-500 dark:text-gray-400">
                                            No episodes found for this season.
                                        </li>
                                        <li
                                            v-else
                                            v-for="ep in season.episodes"
                                            :key="ep.id"
                                            class="-mx-2 flex items-center justify-between rounded-lg px-2 py-1 transition-colors duration-150 hover:bg-gray-100 sm:-mx-3 sm:px-3 sm:py-2 dark:hover:bg-gray-700/50"
                                        >
                                            <span class="max-w-[100px] truncate text-xs sm:max-w-none sm:text-sm">{{
                                                ep.txt || 'Untitled Episode'
                                            }}</span>
                                            <span class="ml-2 hidden font-mono text-xs text-gray-500 sm:ml-4 sm:inline dark:text-gray-400">{{
                                                ep.id
                                            }}</span>
                                            <div class="mx-1 flex-shrink-0 sm:mx-2" v-if="ep.status">
                                                <span
                                                    :class="getStatusClass(ep.status)"
                                                    class="inline-flex rounded-full px-1.5 py-0.5 text-xs leading-5 font-semibold capitalize sm:px-2.5 sm:py-1"
                                                >
                                                    {{ ep.status }}
                                                </span>
                                            </div>
                                            <div class="flex flex-shrink-0 space-x-1 sm:space-x-2">
                                                <button
                                                    class="flex items-center space-x-1 rounded bg-blue-600 px-1.5 py-0.5 text-xs text-white transition-colors duration-200 hover:bg-blue-700 disabled:cursor-wait disabled:opacity-70 sm:px-2 sm:py-1"
                                                    @click.stop="editMovie(ep, movie.id, season.id)"
                                                    :disabled="
                                                        isFetchingEditItemDetails &&
                                                        editingItemContext?.id === ep.id &&
                                                        editingItemContext?.seasonId === season.id
                                                    "
                                                >
                                                    <svg
                                                        v-if="
                                                            isFetchingEditItemDetails &&
                                                            editingItemContext?.id === ep.id &&
                                                            editingItemContext?.seasonId === season.id
                                                        "
                                                        class="h-2.5 w-2.5 animate-spin text-white sm:h-3 sm:w-3"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <circle
                                                            class="opacity-25"
                                                            cx="12"
                                                            cy="12"
                                                            r="10"
                                                            stroke="currentColor"
                                                            stroke-width="4"
                                                        ></circle>
                                                        <path
                                                            class="opacity-75"
                                                            fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                                        ></path>
                                                    </svg>
                                                    <svg
                                                        v-else
                                                        class="h-2.5 w-2.5 sm:h-3 sm:w-3"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                        ></path>
                                                    </svg>
                                                    <span class="hidden sm:inline">Edit</span>
                                                </button>
                                                <button
                                                    class="flex items-center space-x-1 rounded bg-red-600 px-1.5 py-0.5 text-xs text-white transition-colors duration-200 hover:bg-red-700 sm:px-2 sm:py-1"
                                                    @click.stop="openDeleteConfirmation(ep, movie.id, season.id)"
                                                >
                                                    <svg
                                                        class="h-2.5 w-2.5 sm:h-3 sm:w-3"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                        ></path>
                                                    </svg>
                                                    <span class="hidden sm:inline">Delete</span>
                                                </button>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Edit Modal -->
        <div
            v-if="showEditModal"
            class="bg-opacity-75 dark:bg-opacity-75 fixed inset-0 z-[100] flex items-center justify-center bg-gray-600 p-4 transition-opacity duration-300 ease-in-out dark:bg-gray-900"
            @click.self="closeEditModal"
        >
            <!-- Wider Movie Edit Form -->
            <div
                v-if="editingItem && !editingItem.seasonId"
                class="form-container max-h-[90vh] w-full max-w-[95vw] overflow-y-auto rounded-xl bg-white p-6 text-gray-800 shadow-2xl sm:p-8 md:p-10 dark:bg-gray-950 dark:text-gray-100"
            >
                <h2 class="mb-8 text-center text-2xl font-bold tracking-tight text-gray-900 sm:text-left sm:text-3xl dark:text-white">
                    Update Movie
                </h2>
                <form @submit.prevent="submitForm" class="space-y-8">
                    <!-- Movie fields here -->
                    <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="form-group sm:col-span-2 lg:col-span-3">
                            <label for="movie-title" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Movie Title</label
                            ><input
                                id="movie-title"
                                v-model="editForm.title"
                                type="text"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="Enter movie title"
                            />
                        </div>
                        <div class="form-group sm:col-span-2 lg:col-span-3">
                            <label for="movie-description" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Description</label
                            ><textarea
                                id="movie-description"
                                v-model="editForm.description"
                                class="block min-h-[8rem] w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                rows="4"
                                placeholder="Provide a compelling movie description..."
                            ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="movie-genre" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300">Genre</label
                            ><input
                                id="movie-genre"
                                v-model="editForm.genre"
                                type="text"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="e.g., Action, Comedy"
                            />
                        </div>
                        <div class="form-group">
                            <label for="movie-director" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Director</label
                            ><input
                                id="movie-director"
                                v-model="editForm.director"
                                type="text"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="Director's Name"
                            />
                        </div>
                        <div class="form-group">
                            <label for="movie-duration" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Duration</label
                            ><input
                                id="movie-duration"
                                v-model="editForm.duration"
                                type="text"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="e.g., 2h 30m"
                            />
                        </div>
                        <div class="form-group">
                            <label for="movie-ppv_amount" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >PPV rate</label
                            ><input
                                id="movie-ppv_amount"
                                v-model="editForm.ppv_amount"
                                type="text"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="e.g., 200 or Free"
                            />
                        </div>
                        <div class="form-group">
                            <label for="movie-status" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Status</label
                            ><select
                                id="movie-status"
                                v-model="editForm.status"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:focus:ring-blue-500"
                            >
                                <option disabled value="">Select status</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Published">Published</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="movie-upload_date" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Create Date</label
                            ><input
                                id="movie-upload_date"
                                v-model="editForm.create_date"
                                type="date"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:[color-scheme:dark] dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                            />
                        </div>
                        <div class="form-group">
                            <label for="movie-poster" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Poster URL</label
                            ><input
                                id="movie-poster"
                                v-model="editForm.poster"
                                type="url"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="https://example.com/poster.jpg"
                            />
                        </div>
                        <div class="form-group">
                            <label for="movie-cover_img" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Cover Image URL</label
                            ><input
                                id="movie-cover_img"
                                v-model="editForm.cover_img"
                                type="url"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="https://example.com/cover.jpg"
                            />
                        </div>
                        <div class="form-group">
                            <label for="movie-release_on" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Release Date</label
                            ><input
                                id="movie-release_on"
                                v-model="editForm.release_on"
                                type="date"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:[color-scheme:dark] dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                            />
                        </div>

                        <div class="form-group">
                            <label for="movie-url" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300">
                                Movie URL
                            </label>
                            <div class="group relative flex items-center gap-2">
                                <input
                                    id="movie-url"
                                    v-model="editForm.url"
                                    type="url"
                                    class="flex-1 rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                    placeholder="https://example.com/movie.mp4"
                                />
                                <div
                                    v-if="editForm.url"
                                    class="pointer-events-none absolute -bottom-10 left-0 z-20 w-max max-w-[800px] rounded-md bg-gray-800 px-3 py-1.5 text-xs whitespace-pre-wrap text-white opacity-0 shadow-lg transition-opacity duration-200 group-hover:opacity-100"
                                >
                                    {{ editForm.url }}
                                </div>
                                <button
                                    type="button"
                                    @click.prevent="playVideo(editForm.url)"
                                    :disabled="!editForm.url"
                                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-600 transition-colors duration-200 hover:bg-gray-200 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                    title="Preview movie"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- DRM URL with Play Button -->
                        <div class="form-group">
                            <label for="ep-dash_url" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300">
                                DRM URL
                            </label>
                            <!-- Add class="group" here -->
                            <div class="group relative flex items-center gap-2">
                                <input
                                    id="ep-dash_url"
                                    v-model="editForm.dash_url"
                                    type="url"
                                    class="block flex-1 rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                    placeholder="https://example.com/episode.mpd"
                                />

                                <!-- Tooltip becomes visible on hover -->
                                <div
                                    v-if="editForm.dash_url"
                                    class="pointer-events-none absolute -bottom-10 left-0 z-20 w-max max-w-[800px] rounded-md bg-gray-800 px-3 py-1.5 text-xs whitespace-pre-wrap text-white opacity-0 shadow-lg transition-opacity duration-200 group-hover:opacity-100"
                                >
                                    {{ editForm.dash_url }}
                                </div>

                                <button
                                    type="button"
                                    @click.prevent="playDrmVideo"
                                    :disabled="!editForm.dash_url"
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600 transition-colors duration-200 hover:bg-gray-200 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                    title="Preview DRM content"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="trailer" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Trailer URL</label
                            ><input
                                id="title_img"
                                v-model="editForm.trailer"
                                type="text"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="https://example.com/trailer.mpd"
                            />
                        </div>
                        <div class="form-group">
                            <label for="title_img" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Title Image URL</label
                            ><input
                                id="title_img"
                                v-model="editForm.title_img"
                                type="url"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="https://example.com/title.jpg"
                            />
                        </div>
                    </div>
                    <div class="attributes-section border-t border-gray-200 pt-8 dark:border-gray-800">
                        <h3 class="mb-6 text-xl font-semibold text-gray-900 dark:text-white">Movie Attributes</h3>
                        <div class="checkboxes-grid grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                            <label
                                v-for="(label, key) in movieBooleanFields"
                                :key="key"
                                class="checkbox-label group flex cursor-pointer items-center space-x-3"
                            >
                                <input type="checkbox" :id="`movie-checkbox-${key}`" v-model="editForm[key]" class="peer sr-only" />
                                <span
                                    class="custom-checkbox flex h-5 w-5 items-center justify-center rounded-md border border-gray-400 bg-white transition-all duration-150 ease-in-out group-hover:border-gray-500 peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-focus-visible:ring-2 peer-focus-visible:ring-blue-500 peer-focus-visible:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:group-hover:border-gray-500 dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-500 dark:peer-focus-visible:ring-offset-gray-950"
                                    ><svg
                                        class="h-3.5 w-3.5 text-white opacity-0 transition-opacity duration-150 peer-checked:opacity-100"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"></path></svg
                                ></span>
                                <span
                                    class="text-sm font-medium text-gray-700 transition-colors select-none group-hover:text-gray-900 dark:text-gray-300 dark:group-hover:text-white"
                                    >{{ label }}</span
                                >
                            </label>
                        </div>
                    </div>
                    <div class="flex flex-col justify-end space-y-3 pt-8 sm:flex-row sm:space-y-0 sm:space-x-4">
                        <button
                            type="button"
                            @click="closeEditModal"
                            class="cancel-button w-full rounded-lg bg-gray-200 px-8 py-3 font-semibold text-gray-800 shadow-md transition-all duration-150 ease-in-out hover:bg-gray-300 focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:outline-none sm:w-auto dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-950"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="submit-button flex w-full items-center justify-center rounded-lg bg-blue-600 px-8 py-3 font-semibold text-white shadow-md transition-all duration-150 ease-in-out hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-950"
                            :disabled="modalLoading"
                        >
                            <span v-if="!modalLoading">Update Movie</span>
                            <span v-else class="loading-spinner h-5 w-5 animate-spin rounded-full border-2 border-white/40 border-t-white"></span>
                        </button>
                    </div>
                    <div
                        v-if="modalMessage"
                        class="message mt-6 rounded-lg p-4 text-center text-sm font-medium"
                        :class="{
                            'border border-green-300 bg-green-50 text-green-700 dark:border-green-600/50 dark:bg-green-700/20 dark:text-green-300':
                                !modalMessage.startsWith('Failed'),
                            'border border-red-300 bg-red-50 text-red-700 dark:border-red-600/50 dark:bg-red-700/20 dark:text-red-300':
                                modalMessage.startsWith('Failed'),
                        }"
                    >
                        {{ modalMessage }}
                    </div>
                </form>
            </div>

            <!-- Episode Edit Form -->
            <div
                v-if="editingItem && editingItem.seasonId"
                class="form-container max-h-[90vh] w-full max-w-[95vw] overflow-y-auto rounded-xl bg-white p-6 text-gray-800 shadow-2xl sm:p-8 md:p-10 dark:bg-gray-950 dark:text-gray-100"
            >
                <h2 class="mb-8 text-center text-2xl font-bold tracking-tight text-gray-900 sm:text-left sm:text-3xl dark:text-white">
                    Update Episode
                </h2>
                <form @submit.prevent="submitForm" class="space-y-8">
                    <!-- Episode fields here -->
                    <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="form-group">
                            <label for="ep-title" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Episode Title</label
                            ><input
                                id="ep-title"
                                v-model="editForm.title"
                                type="text"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="Enter episode title"
                            />
                        </div>
                        <div class="form-group sm:col-span-2 lg:col-span-3">
                            <label for="ep-desc" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Episode Description</label
                            ><textarea
                                id="ep-desc"
                                v-model="editForm.desc"
                                class="block min-h-[8rem] w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                rows="4"
                                placeholder="Provide episode details..."
                            ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="ep-txt" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Episode Identifier (e.g., S1 E1)</label
                            ><input
                                id="ep-txt"
                                v-model="editForm.txt"
                                type="text"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="S1 E1"
                            />
                        </div>
                        <div class="form-group">
                            <label for="ep-season_id" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Season ID</label
                            ><input
                                id="ep-season_id"
                                v-model="editForm.season_id"
                                type="text"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="Enter Season ID"
                                readonly
                            />
                        </div>
                        <div class="form-group">
                            <label for="ep-ppv_amount" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >PPV Rate</label
                            ><input
                                id="ep-ppv_amount"
                                v-model="editForm.ppv_amount"
                                type="text"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="e.g., 200 or Free"
                            />
                        </div>
                        <div class="form-group">
                            <label for="ep-img" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Cover Image URL</label
                            ><input
                                id="ep-img"
                                v-model="editForm.img"
                                type="url"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                placeholder="https://example.com/image.jpg"
                            />
                        </div>
                        <!-- Video URL with Play Button -->
                        <div class="form-group">
                            <label for="ep-url" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300">
                                Video URL
                            </label>
                            <div class="group relative flex items-center gap-2">
                                <input
                                    id="ep-url"
                                    v-model="editForm.url"
                                    type="url"
                                    class="block flex-1 rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                    placeholder="https://example.com/episode.mp4"
                                />
                                <div
                                    v-if="editForm.url"
                                    class="pointer-events-none absolute -bottom-10 left-0 z-20 w-max max-w-[800px] rounded-md bg-gray-800 px-3 py-1.5 text-xs whitespace-pre-wrap text-white opacity-0 shadow-lg transition-opacity duration-200 group-hover:opacity-100"
                                >
                                    {{ editForm.url }}
                                </div>
                                <button
                                    type="button"
                                    @click.prevent="playVideo(editForm.url)"
                                    :disabled="!editForm.url"
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600 transition-colors duration-200 hover:bg-gray-200 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                    title="Preview video"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <!-- DRM URL with Play Button -->
                        <div class="form-group">
                            <label for="ep-dash_url" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300">
                                DRM URL
                            </label>
                            <!-- Add class="group" here -->
                            <div class="group relative flex items-center gap-2">
                                <input
                                    id="ep-dash_url"
                                    v-model="editForm.dash_url"
                                    type="url"
                                    class="block flex-1 rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                                    placeholder="https://example.com/episode.mpd"
                                />

                                <!-- Tooltip becomes visible on hover -->
                                <div
                                    v-if="editForm.dash_url"
                                    class="pointer-events-none absolute -bottom-10 left-0 z-20 w-max max-w-[800px] rounded-md bg-gray-800 px-3 py-1.5 text-xs whitespace-pre-wrap text-white opacity-0 shadow-lg transition-opacity duration-200 group-hover:opacity-100"
                                >
                                    {{ editForm.dash_url }}
                                </div>

                                <button
                                    type="button"
                                    @click.prevent="playDrmVideo"
                                    :disabled="!editForm.dash_url"
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600 transition-colors duration-200 hover:bg-gray-200 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                    title="Preview DRM content"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ep-status" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300">Status</label
                            ><select
                                id="ep-status"
                                v-model="editForm.status"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700 dark:focus:ring-blue-500"
                            >
                                <option disabled value="">Select status</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Published">Published</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ep-upload_date" class="mb-1.5 block text-sm leading-6 font-medium text-gray-700 dark:text-gray-300"
                                >Create Date</label
                            ><input
                                id="ep-upload_date"
                                v-model="editForm.create_date"
                                type="date"
                                class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-gray-300 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-gray-100 dark:[color-scheme:dark] dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-blue-500"
                            />
                        </div>
                    </div>
                    <div class="attributes-section border-t border-gray-200 pt-8 dark:border-gray-800">
                        <h3 class="mb-6 text-xl font-semibold text-gray-900 dark:text-white">Episode Attributes</h3>
                        <div class="checkboxes-grid grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                            <label
                                v-for="(label, key) in episodeBooleanFields"
                                :key="key"
                                class="checkbox-label group flex cursor-pointer items-center space-x-3"
                            >
                                <input type="checkbox" :id="`ep-checkbox-${key}`" v-model="editForm[key]" class="peer sr-only" />
                                <span
                                    class="custom-checkbox flex h-5 w-5 items-center justify-center rounded-md border border-gray-400 bg-white transition-all duration-150 ease-in-out group-hover:border-gray-500 peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-focus-visible:ring-2 peer-focus-visible:ring-blue-500 peer-focus-visible:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:group-hover:border-gray-500 dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-500 dark:peer-focus-visible:ring-offset-gray-950"
                                    ><svg
                                        class="h-3.5 w-3.5 text-white opacity-0 transition-opacity duration-150 peer-checked:opacity-100"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"></path></svg
                                ></span>
                                <span
                                    class="text-sm font-medium text-gray-700 transition-colors select-none group-hover:text-gray-900 dark:text-gray-300 dark:group-hover:text-white"
                                    >{{ label }}</span
                                >
                            </label>
                        </div>
                    </div>
                    <div class="flex flex-col justify-end space-y-3 pt-8 sm:flex-row sm:space-y-0 sm:space-x-4">
                        <button
                            type="button"
                            @click="closeEditModal"
                            class="cancel-button w-full rounded-lg bg-gray-200 px-8 py-3 font-semibold text-gray-800 shadow-md transition-all duration-150 ease-in-out hover:bg-gray-300 focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:outline-none sm:w-auto dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-950"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="submit-button flex w-full items-center justify-center rounded-lg bg-blue-600 px-8 py-3 font-semibold text-white shadow-md transition-all duration-150 ease-in-out hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-950"
                            :disabled="modalLoading"
                        >
                            <span v-if="!modalLoading">Update Episode</span>
                            <span v-else class="loading-spinner h-5 w-5 animate-spin rounded-full border-2 border-white/40 border-t-white"></span>
                        </button>
                    </div>
                    <div
                        v-if="modalMessage"
                        class="message mt-6 rounded-lg p-4 text-center text-sm font-medium"
                        :class="{
                            'border border-green-300 bg-green-50 text-green-700 dark:border-green-600/50 dark:bg-green-700/20 dark:text-green-300':
                                !modalMessage.startsWith('Failed'),
                            'border border-red-300 bg-red-50 text-red-700 dark:border-red-600/50 dark:bg-red-700/20 dark:text-red-300':
                                modalMessage.startsWith('Failed'),
                        }"
                    >
                        {{ modalMessage }}
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div
            v-if="showDeleteConfirmModal"
            class="bg-opacity-75 fixed inset-0 z-[110] flex items-center justify-center bg-gray-800 p-4 transition-opacity duration-300 ease-in-out"
            @click.self="closeDeleteConfirmation"
        >
            <div class="w-full max-w-md transform rounded-lg bg-white p-6 shadow-xl transition-all sm:p-8 dark:bg-gray-900">
                <div class="text-center">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                            />
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                        Delete {{ itemToDelete?.type === 'episode' ? 'Episode' : 'Movie' }}
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Are you sure you want to delete "{{ itemToDelete?.titleOrTxt }}"? This action cannot be undone.
                        </p>
                    </div>
                </div>
                <div
                    v-if="deleteModalMessage"
                    class="mt-4 rounded-md p-3 text-center text-sm"
                    :class="{
                        'border border-green-300 bg-green-50 text-green-700 dark:border-green-600/50 dark:bg-green-700/20 dark:text-green-300':
                            !deleteModalMessage.startsWith('Failed'),
                        'border border-red-300 bg-red-50 text-red-700 dark:border-red-600/50 dark:bg-red-700/20 dark:text-red-300':
                            deleteModalMessage.startsWith('Failed'),
                    }"
                >
                    {{ deleteModalMessage }}
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                    <button
                        @click="confirmDeleteItem"
                        :disabled="isDeleting"
                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 sm:col-start-2 sm:text-sm dark:focus:ring-offset-gray-900"
                    >
                        <span v-if="!isDeleting">Confirm Delete</span>
                        <span v-else class="flex items-center">
                            <svg
                                class="mr-3 -ml-1 h-5 w-5 animate-spin text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                ></path>
                            </svg>
                            Deleting...
                        </span>
                    </button>
                    <button
                        @click="closeDeleteConfirmation"
                        :disabled="isDeleting"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none disabled:opacity-50 sm:col-start-1 sm:mt-0 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-900"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
        <div v-if="showPlayer" class="fixed inset-0 z-[130]">
            <ShakaPlayer
                :videoUrl="currentVideo.url"
                :isDrm="currentVideo.isDrm"
                :licenseToken="currentVideo.token"
                :licenseUrl="currentVideo.licenseUrl"
                @close="showPlayer = false"
            />
        </div>
    </div>
</template>

<script setup>
import ShakaPlayer from '@/components/shakaPlayerCom.vue';
import { db } from '@/firebase';
import axios from 'axios';
import { getAuth } from 'firebase/auth';
import { collection, getDocs } from 'firebase/firestore';
import { computed, onMounted, ref } from 'vue';
import { toast } from 'vue3-toastify';

// --- Reactive State ---
const auth = getAuth();
console.log('User ID:', uid);
const movies = ref([]);
const search = ref('');
const sortOrder = ref('asc');
const loading = ref(false); // Main search loading
const expandedMovie = ref(null);
const hasSearchedAtLeastOnce = ref(false);

const loadingSeasonsFor = ref(new Set()); // Tracks loading state for seasons per movie ID
const loadingEpisodesFor = ref(new Set()); // Tracks loading state for episodes per season ID

const showDeleteConfirmModal = ref(false);
const itemToDelete = ref(null);
const isDeleting = ref(false);
const deleteModalMessage = ref('');

const showPlayer = ref(false);
const currentVideo = ref('');

// Modal State
const showEditModal = ref(false);
const editingItem = ref(null);
const editForm = ref({});
const modalLoading = ref(false);
const modalMessage = ref('');
const isFetchingEditItemDetails = ref(false);
const editingItemContext = ref(null);

auth.onAuthStateChanged(async (user) => {
    if (user) {
        const uid = user.uid; // ✅ Firebase UI/ 🔐 ID token to send to backend

        console.log('UID:', uid);
    }
});

// Simple function to play the video
const playVideo = (url, isDrm = false, token = '', licenseUrl = '') => {
    currentVideo.value = {
        url,
        isDrm,
        token,
        licenseUrl,
    };
    showPlayer.value = true;
};

// In your <script setup>

const playDrmVideo = async () => {
    console.log('--- playDrmVideo: Clicked! ---');

    if (!editForm.value.dash_url) {
        toast.warn('Please enter a valid DRM URL first.');
        return;
    }

    loading.value = true;
    console.log('Set loading to true. Starting DRM process...');

    try {
        // Step A: Encrypt URL
        const encrypted = await encryptViaProxy(editForm.value.dash_url);
        console.log('Encrypted URL result:', encrypted);

        if (!encrypted) {
            // This is a critical check. If encryption fails, the process cannot continue.
            throw new Error('Failed to encrypt the Dash URL via proxy. The result was empty.');
        }
        const tokenRes = await axios.get(route('proxy.get'), {
            params: {
                endpoint: 'preview',
                mpd: encrypted,
            },
        });

        const token = tokenRes.data.token;
        if (!token || typeof token !== 'string') {
            throw new Error('Invalid or missing token in the server response.');
        }
        console.log('Token extracted successfully:', token);

        // Step C: Play Video
        const widevineLicenseUrl = 'https://drm-widevine-licensing.axprod.net/AcquireLicense';
        playVideo(editForm.value.dash_url, true, token, widevineLicenseUrl);
    } catch (err) {
        console.error("!!! DRM Playback FAILED at some point in the 'try' block !!!", err);
        const errorMessage = err.response?.data?.message || err.message || 'An unknown error occurred during DRM playback.';
        toast.error(`DRM Playback Failed: ${errorMessage}`);
        // error.value = `DRM Playback Failed: ${errorMessage}`; // If using a ref for the modal
    } finally {
        loading.value = false;
    }
};
// --- Form Field Definitions ---
const movieBooleanFields = ref({
    isProtected: 'Protected',
    isBollywood: 'Bollywood',
    isCompleted: 'Completed',
    isDocumentary: 'Documentary',
    isAgeRestricted: 'Age Restricted',
    isDubbed: 'Dubbed',
    isEnable: 'Enable',
    isHollywood: 'Hollywood',
    isKorean: 'Korean',
    isMizo: 'Mizo',
    isPayPerView: 'Pay Per View',
    isPremium: 'Premium',
    isSeason: 'Season',
    isSubtitle: 'Has Subtitle',
    notification: 'Notification',
    isChildMode: 'Child Mode',
});

const episodeBooleanFields = ref({
    isProtected: 'Protected',
    isEnable: 'Enable',
    isPPV: 'Pay Per View',
    isPremium: 'Premium',
    notification: 'Notification',
});

const getInitialMovieForm = () => ({
    title: '',
    description: '',
    genre: '',
    notification: false,
    director: '',
    duration: '',
    title_img: '',
    ppv_amount: '',
    status: '',
    create_date: '',
    poster: '',
    cover_img: '',
    trailer: '',
    release_on: '',
    url: '',
    dash_url: '',
    ...Object.fromEntries(Object.keys(movieBooleanFields.value).map((key) => [key, false])),
});

const getInitialEpisodeForm = () => ({
    title: '',
    desc: '',
    txt: '',
    season_id: '',
    ppv_amount: '',
    notification: false,
    img: '',
    url: '',
    dash_url: '',
    status: '',
    create_date: '',
    ...Object.fromEntries(Object.keys(episodeBooleanFields.value).map((key) => [key, false])),
});

// --- Utility Functions ---
const formatDateForInput = (dateValue) => {
    if (!dateValue) return '';
    try {
        // Create the date object
        const d = new Date(typeof dateValue === 'object' && dateValue.seconds ? dateValue.seconds * 1000 : dateValue);

        if (isNaN(d.valueOf())) return '';

        // CHANGE: Use local methods (getFullYear, getMonth, getDate)
        // instead of UTC methods (getUTCFullYear, etc.)
        const year = d.getFullYear();
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;
    } catch (e) {
        console.error('Could not format date:', dateValue, e);
        return '';
    }
};
const decryptUrl = async (urlToDecrypt) => {
    if (!urlToDecrypt || typeof urlToDecrypt !== 'string' || !urlToDecrypt.trim()) return '';
    try {
        const response = await axios.post(route('decrypt'), { encrypted_url: urlToDecrypt });
        return response.data && typeof response.data.url === 'string' ? response.data.url : urlToDecrypt;
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
                message: plainUrl,
            },
        });
        return res.data.encrypted || '';
    } catch (e) {
        console.warn(`Encryption failed for: ${plainUrl}`, e);
        return '';
    }
};

const fetchMovies = async (query = '') => {
    loading.value = true;
    movies.value = [];
    try {
        const response = await axios.get(
            route('proxy.get', {
                endpoint: 'search',
                q: query,
                age_restriction: String(true),
                is_enable: String(false),
                headers: {
                    'X-User-Id': `${uid}`,
                },
            }),
        );
        movies.value = Array.isArray(response.data) ? response.data : [];
    } catch (error) {
        console.error('Failed to fetch movies:', error);
        toast.error('Failed to fetch movies. Please try again.');
        movies.value = [];
    } finally {
        loading.value = false;
    }
};

const performSearch = async () => {
    hasSearchedAtLeastOnce.value = true;
    await fetchMovies(search.value.trim());
};

onMounted(() => {
    /* No initial fetch on component mount */
});

const filteredMovies = computed(() => {
    if (!Array.isArray(movies.value)) return [];
    return [...movies.value].sort((a, b) => {
        const titleA = String(a.title || '').toLowerCase();
        const titleB = String(b.title || '').toLowerCase();
        return sortOrder.value === 'asc' ? titleA.localeCompare(titleB) : titleB.localeCompare(titleA);
    });
});

const getStatusClass = (status) => {
    if (!status) return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
    status = status.toLowerCase();
    switch (status) {
        case 'published':
            return 'bg-green-100 text-green-800 dark:bg-green-700/30 dark:text-green-300';
        case 'draft':
            return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700/30 dark:text-yellow-400';
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
                    endpoint: `episode/${itemIdToFetch}`,
                },
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            itemDetails = response.data.episode;
            if (!itemDetails) throw new Error('Episode data not found in Zostream API response.');
            console.log('Fetched Zostream Episode Details:', itemDetails);
        } else {
            // Fetching movie details (assumed via your proxy)
            const response = await axios.get(route('proxy.get', { endpoint: 'movies', id: itemIdToFetch, category_type: 'movie', is_enable: false }));
            itemDetails = response.data; // Assuming proxy returns movie data directly
            if (!itemDetails) throw new Error('Movie data not found in proxy response.');
            console.log('Fetched Proxied Movie Details:', itemDetails);
        }

        if (typeof itemDetails !== 'object' || Array.isArray(itemDetails)) {
            throw new Error(`Invalid item data structure. Expected a single object.`);
        }

        const form = editForm.value;
        if (isEpisode) {
            form.title = itemDetails.title || itemDetails.name || '';
            form.desc = itemDetails.desc || '';
            form.txt = itemDetails.txt || '';
            form.season_id = pSeasonId || itemDetails.season_id || '';
            form.ppv_amount = itemDetails.ppv_amount || '';
            form.status = itemDetails.status || '';
            form.create_date = formatDateForInput(itemDetails.create_date);
            form.img = itemDetails.img || '';
            form.url = itemDetails.url ? await decryptUrl(itemDetails.url) : '';
            form.dash_url = itemDetails.dash_url ? await decryptUrl(itemDetails.dash_url) : '';
            for (const key in episodeBooleanFields.value) form[key] = !!itemDetails[key];
        } else {
            form.title = itemDetails.title || '';
            form.description = itemDetails.description || '';
            form.title_img = itemDetails.title_img || '';
            form.genre = itemDetails.genre || '';
            form.director = itemDetails.director || '';
            form.duration = itemDetails.duration || '';
            form.ppv_amount = itemDetails.ppv_amount || '';
            form.status = itemDetails.status || '';
            form.create_date = formatDateForInput(itemDetails.create_date || itemDetails.upload_date);
            form.release_on = formatDateForInput(itemDetails.release_on);
            form.poster = itemDetails.poster || '';
            form.cover_img = itemDetails.cover_img || '';
            form.url = itemDetails.url ? await decryptUrl(itemDetails.url) : '';
            form.dash_url = itemDetails.dash_url ? await decryptUrl(itemDetails.dash_url) : '';
            for (const key in movieBooleanFields.value) form[key] = !!itemDetails[key];
        }

        editingItem.value = { id: itemIdToFetch, movieId: pMovieId || (isEpisode ? null : itemIdToFetch), seasonId: pSeasonId };
        showEditModal.value = true;
    } catch (error) {
        console.error('Failed to prepare item for editing:', error);
        let errorMessage = error.response ? `API Error: ${error.response.data?.message || error.message}` : error.message;
        toast.error(`Error loading details: ${errorMessage}`);
    } finally {
        isFetchingEditItemDetails.value = false;
        editingItemContext.value = null;
    }
};

const closeEditModal = () => {
    showEditModal.value = false;
    editingItem.value = null;
    editForm.value = {};
    modalMessage.value = '';
};

const submitForm = async () => {
    modalLoading.value = true;
    modalMessage.value = '';
    try {
        const currentFormState = JSON.parse(JSON.stringify(editForm.value));
        const itemCtx = editingItem.value;
        if (!itemCtx || !itemCtx.id) throw new Error('Editing context is invalid.');

        const isEpisode = !!itemCtx.seasonId;
        if (currentFormState.url) currentFormState.url = await encryptViaProxy(currentFormState.url);
        if (currentFormState.dash_url) currentFormState.dash_url = await encryptViaProxy(currentFormState.dash_url);

        const payload = { ...currentFormState };
        console.log('data to update:', payload);
        const booleanFieldsConfig = isEpisode ? episodeBooleanFields.value : movieBooleanFields.value;
        for (const boolKey in booleanFieldsConfig) payload[boolKey] = !!payload[boolKey];

        let apiSegment = isEpisode ? 'episode' : 'movies';
        await axios.put(route('proxy.put'), payload, {
            params: { endpoint: `${apiSegment}/${itemCtx.id}` },
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });

        toast.success(`${isEpisode ? 'Episode' : 'Movie'} updated successfully!`);

        if (isEpisode) {
            const movieToUpdate = movies.value.find((m) => m.id === itemCtx.movieId);
            const seasonToUpdate = movieToUpdate?.seasons?.find((s) => s.id === itemCtx.seasonId);
            const epIndex = seasonToUpdate?.episodes?.findIndex((e) => e.id === itemCtx.id);
            if (epIndex !== undefined && epIndex > -1) {
                Object.assign(seasonToUpdate.episodes[epIndex], { ...editForm.value, txt: editForm.value.title || editForm.value.txt });
            }
        } else {
            const movieIndex = movies.value.findIndex((m) => m.id === itemCtx.id);
            if (movieIndex > -1) Object.assign(movies.value[movieIndex], editForm.value);
        }
        closeEditModal();
    } catch (err) {
        console.error('Update submission failed:', err.response || err);
        let errorMsg = err.response ? err.response.data?.message || JSON.stringify(err.response.data) : err.message;
        modalMessage.value = `Update Failed: ${errorMsg}`;
        toast.error(`Update Failed: ${errorMsg}`);
    } finally {
        modalLoading.value = false;
    }
};

const openDeleteConfirmation = (item, parentMovieId = null, parentSeasonId = null) => {
    const isEpisode = !!parentSeasonId;
    itemToDelete.value = {
        id: item.id,
        type: isEpisode ? 'episode' : 'movie',
        titleOrTxt: item.title || item.txt || 'this item',
        parentMovieId: parentMovieId,
        parentSeasonId: parentSeasonId,
    };
    deleteModalMessage.value = '';
    showDeleteConfirmModal.value = true;
};

const closeDeleteConfirmation = () => {
    showDeleteConfirmModal.value = false;
    itemToDelete.value = null;
    isDeleting.value = false;
};

const confirmDeleteItem = async () => {
    if (!itemToDelete.value) return;
    isDeleting.value = true;
    deleteModalMessage.value = '';
    const itemCtx = itemToDelete.value;
    try {
        let apiDeleteSegment = itemCtx.type === 'episode' ? 'episode' : 'movies';
        await axios.delete(route('proxy.delete'), {
            params: { endpoint: `${apiDeleteSegment}/${itemCtx.id}` },
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });

        toast.success(`${itemCtx.type.charAt(0).toUpperCase() + itemCtx.type.slice(1)} deleted successfully!`);

        if (itemCtx.type === 'episode') {
            const movieToUpdate = movies.value.find((m) => m.id === itemCtx.parentMovieId);
            if (movieToUpdate?.seasons) {
                const seasonToUpdate = movieToUpdate.seasons.find((s) => s.id === itemCtx.parentSeasonId);
                if (seasonToUpdate?.episodes) {
                    seasonToUpdate.episodes = seasonToUpdate.episodes.filter((e) => e.id !== itemCtx.id);
                }
            }
        } else {
            movies.value = movies.value.filter((m) => m.id !== itemCtx.id);
        }
        setTimeout(() => closeDeleteConfirmation(), 500);
    } catch (err) {
        console.error(`Failed to delete ${itemCtx.type}:`, err.response || err);
        let errorMsg = err.response ? err.response.data?.message || JSON.stringify(err.response.data) : err.message;
        deleteModalMessage.value = `Failed: ${errorMsg}`;
        toast.error(`Deletion failed: ${errorMsg}`);
    } finally {
        isDeleting.value = false;
    }
};

const toggleMovie = async (movie) => {
    if (expandedMovie.value === movie.id) {
        expandedMovie.value = null;
        return;
    }
    expandedMovie.value = movie.id;

    // Fetch seasons from Firestore if movie.isSeason and seasons aren't loaded yet
    if (movie.isSeason && (!movie.seasons || movie.seasons.length === 0)) {
        loadingSeasonsFor.value.add(movie.id);
        try {
            const qSnap = await getDocs(collection(db, `movie/${movie.id}/season`));
            movie.seasons = qSnap.docs
                .map((d) => ({
                    id: d.id,
                    ...d.data(),
                    txt: d.data().txt || d.data().title || `Season ${d.id.slice(-2)}`,
                    episodes: [],
                    showEpisodes: false,
                }))
                .sort((a, b) => (a.txt || '').localeCompare(b.txt || '', undefined, { numeric: true }));
        } catch (err) {
            console.error(`Error fetching seasons for movie ${movie.id}:`, err);
            toast.error('Failed to load seasons.');
            movie.seasons = [];
        } finally {
            loadingSeasonsFor.value.delete(movie.id);
        }
    }
};

const toggleSeasonEpisodes = async (movie, season) => {
    season.showEpisodes = !season.showEpisodes;

    // Fetch episodes for this season from your API if they haven't been loaded
    if (season.showEpisodes && (!season.episodes || season.episodes.length === 0)) {
        loadingEpisodesFor.value.add(season.id);
        try {
            const resp = await axios.get(route('proxy.get', { id: season.id, endpoint: 'episodes', is_enable: false }));
            if (Array.isArray(resp.data)) {
                season.episodes = resp.data
                    .filter((ep) => ep && ep.id != null && String(ep.id).trim() !== '')
                    .map((ep) => ({
                        ...ep,
                        id: String(ep.id).trim(),
                        txt: ep.txt || ep.title || ep.name || `Episode ${String(ep.id).trim()}`,
                    }))
                    .sort((a, b) => {
                        const numA = parseInt(String(a.txt).match(/\d+/)?.[0] || String(a.id));
                        const numB = parseInt(String(b.txt).match(/\d+/)?.[0] || String(b.id));
                        if (!isNaN(numA) && !isNaN(numB)) return numA - numB;
                        return (a.txt || '').localeCompare(b.txt || '', undefined, { numeric: true });
                    });
            } else {
                season.episodes = [];
            }
        } catch (err) {
            console.error(`Failed to fetch episodes for season ${season.id}:`, err);
            toast.error('Failed to load episodes.');
            season.episodes = [];
        } finally {
            loadingEpisodesFor.value.delete(season.id);
        }
    }
};
</script>

<style scoped>
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
