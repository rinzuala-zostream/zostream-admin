<template>
    <div class="p-4 min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Movie Collection</h1>
            </div>

            <!-- Search and Sort -->
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        v-model="search" 
                        placeholder="Search movies..." 
                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 transition-all duration-200"
                    />
                </div>
                
                <select 
                    v-model="sortOrder" 
                    class="px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 transition-all duration-200"
                >
                    <option value="asc">A-Z</option>
                    <option value="desc">Z-A</option>
                </select>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="flex justify-center items-center py-12">
                <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-blue-500"></div>
            </div>

            <!-- Empty State -->
            <div v-else-if="search && filteredMovies.length === 0" class="text-center py-12">
                <div class="mx-auto w-24 h-24 text-gray-400 dark:text-gray-500 mb-4">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">No movies found</h3>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Try adjusting your search query</p>
            </div>

            <!-- Movie List -->
            <ul v-if="search && filteredMovies.length > 0" class="space-y-2">
                <li 
                    v-for="movie in filteredMovies" 
                    :key="movie.id"
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden border border-gray-200 dark:border-gray-700"
                >
                    <div 
                        class="flex items-center justify-between p-4 cursor-pointer"
                        @click="toggleMovie(movie)"
                    >
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 flex-shrink-0 rounded-lg bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                                </svg>
                            </div>
                            <span class="font-medium truncate">{{ movie.title }}</span>
                        </div>
                        <button 
                            class="px-3 py-1.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center space-x-1"
                            @click.stop="editMovie(movie)"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Edit</span>
                        </button>
                    </div>

                    <!-- Seasons and Episodes -->
                    <div 
                        v-if="expandedMovie === movie.id && movie.isSeason"
                        class="border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30 transition-all duration-200"
                    >
                        <div 
                            v-for="season in movie.seasons || []" 
                            :key="season.id" 
                            class="px-4 py-3"
                        >
                            <div 
                                class="flex items-center justify-between font-medium text-sm cursor-pointer hover:text-blue-500 transition-colors duration-150"
                                @click="toggleSeasonEpisodes(movie, season)"
                            >
                                <div class="flex items-center space-x-2">
                                    <svg 
                                        class="w-4 h-4 transform transition-transform duration-200" 
                                        :class="{'rotate-90': season.showEpisodes}"
                                        fill="none" 
                                        stroke="currentColor" 
                                        viewBox="0 0 24 24" 
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    <span>{{ season.txt }}</span>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ season.episodes.length }} episode{{ season.episodes.length !== 1 ? 's' : '' }}
                                </span>
                            </div>
                            <ul 
                                v-if="season.showEpisodes" 
                                class="ml-6 mt-2 space-y-2 animate-fadeIn"
                            >
                                <li 
                                    v-for="ep in season.episodes" 
                                    :key="ep.id" 
                                    class="flex items-center justify-between py-2 px-3 -mx-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors duration-150"
                                >
                                    <span class="text-sm">{{ ep.txt || 'Untitled Episode' }}</span>
                                    <button
                                        class="px-2 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition-colors duration-200 flex items-center space-x-1"
                                        @click.stop="editMovie(ep)"
                                    >
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span>Edit</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { db } from '@/firebase'; // Adjust path based on your project structure
import { collection, getDocs } from 'firebase/firestore';

const movies = ref([]);
const search = ref('');
const sortOrder = ref('asc');
const loading = ref(false);
const expandedMovie = ref(null);

const fetchMovies = async () => {
    try {
        loading.value = true;
        const response = await axios.get(route('proxy.get'), {
            params: {
                endpoint: 'movies',
                range: '1-6000',
                category: 'all',
                category_type: 'movie',
                age_restriction: true,
            },
        });
        movies.value = response.data || [];
    } catch (error) {
        console.error('Failed to fetch movies:', error);
    } finally {
        loading.value = false;
    }
};

const filteredMovies = computed(() => {
    const filtered = movies.value.filter(movie =>
        movie.title.toLowerCase().includes(search.value.toLowerCase())
    );

    return sortOrder.value === 'asc'
        ? filtered.sort((a, b) => a.title.localeCompare(b.title))
        : filtered.sort((a, b) => b.title.localeCompare(a.title));
});

const editMovie = (movie) => {
    console.log('Edit movie:', movie);
    // router.push({ name: 'EditMovie', params: { id: movie.id } });
};

const toggleMovie = async (movie) => {
    if (expandedMovie.value === movie.id) {
        expandedMovie.value = null;
        return;
    }

    expandedMovie.value = movie.id;

    // Fetch seasons if this is a series
    if (movie.isSeason && !movie.seasons) {
        movie.seasons = [];
        try {
            const qSnap = await getDocs(collection(db, `movie/${movie.id}/season`));
            const fetchedSeasons = qSnap.docs.map(d => ({
                id: d.data().id || d.id,
                txt: d.data().txt || `S ${d.id}`,
                episodes: [],
                showEpisodes: false
            })).sort((a, b) => a.txt.localeCompare(b.txt, undefined, { numeric: true }));

            movie.seasons = fetchedSeasons;
        } catch (err) {
            console.error("Fetch Seasons Error:", err);
            movie.seasons = [];
        }
    }
};

const toggleSeasonEpisodes = async (movie, season) => {
    if (!season.showEpisodes) {
        if (!season.episodes || season.episodes.length === 0) {
            try {
                const resp = await axios.get(route("proxy.get"), {
                    params: {
                        id: season.id,
                        endpoint: "episodes"
                    }
                });

                if (Array.isArray(resp.data)) {
                    season.episodes = resp.data
                        .filter(ep => ep?.id && String(ep.id).trim())
                        .map(ep => ({
                            id: String(ep.id).trim(),
                            txt: ep.txt || `Ep ${ep.id}`,
                        }));
                }
            } catch (err) {
                console.error(`Failed to fetch episodes for season ${season.id}`, err);
                season.episodes = [];
            }
        }
        season.showEpisodes = true;
    } else {
        season.showEpisodes = false;
    }
};

onMounted(() => {
fetchMovies() 
});
</script>

<style scoped>
.animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>