<template>
  <div
    class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-4 md:p-8 transition-colors duration-200"
  >
    <div class="max-w-6xl mx-auto">
      <!-- Header -->
      <div class="flex items-center justify-between mb-8">
        <h1
          class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent"
        >
          🎬 Banner Management
        </h1>
      </div>

      <!-- Add Banner Card -->
      <div
        class="mb-10 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 transition-all hover:shadow-xl"
      >
        <div class="p-6 md:p-8">
          <h2 class="text-xl font-semibold mb-6 flex items-center gap-2">
            <span class="text-blue-500">✨</span>
            <span>Add New Banner</span>
          </h2>

          <form @submit.prevent="addBanner" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label
                  class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300"
                  >Movie Title</label
                >
                <input
                  v-model="newBanner.text"
                  placeholder="Enter movie title"
                  class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 transition-all"
                  required
                />
              </div>
              <div>
                <label
                  class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300"
                  >Genre</label
                >
                <input
                  v-model="newBanner.genre"
                  placeholder="Action, Drama, Comedy"
                  class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 transition-all"
                  required
                />
              </div>
              <div>
                <label
                  class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300"
                  >Movie ID</label
                >
                <input
                  v-model="newBanner.id"
                  placeholder="Enter unique ID"
                  class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 transition-all"
                  required
                />
              </div>
              <div>
                <label
                  class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300"
                  >Cover Image URL</label
                >
                <input
                  v-model="newBanner.img"
                  placeholder="https://example.com/cover.jpg"
                  class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 transition-all"
                  required
                />
              </div>
              <div class="md:col-span-2">
                <label
                  class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300"
                  >Poster Image URL</label
                >
                <input
                  v-model="newBanner.poster"
                  placeholder="https://example.com/poster.jpg"
                  class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 transition-all"
                  required
                />
              </div>
            </div>

            <button
              type="submit"
              class="mt-4 w-full md:w-auto px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-md transition-all transform hover:scale-[1.02]"
            >
              Add Banner
            </button>
          </form>
        </div>
      </div>

      <!-- Banners List -->
      <div v-if="Object.keys(banners).length === 0" class="text-center py-12">
        <div class="text-gray-400 dark:text-gray-500 mb-4">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-12 w-12 mx-auto"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="1.5"
              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
            />
          </svg>
        </div>
        <p class="text-lg text-gray-500 dark:text-gray-400">
          No banners available
        </p>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
          Add your first banner using the form above
        </p>
      </div>

      <div v-else class="space-y-5">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
          <span class="text-blue-500">📋</span>
          <span>Your Banners</span>
          <span
            class="ml-auto text-sm font-normal text-gray-500 dark:text-gray-400"
          >
            {{ Object.keys(banners).length }}
            {{ Object.keys(banners).length === 1 ? "banner" : "banners" }}
          </span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
          <div
            v-for="(item, key) in banners"
            :key="key"
            class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all"
          >
            <div
              class="relative h-40 bg-gray-100 dark:bg-gray-700 overflow-hidden"
            >
              <img
                :src="item.img"
                :alt="item.text"
                class="w-full h-full object-cover transition-transform hover:scale-105 duration-500"
              />
              <div
                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4"
              >
                <h3 class="text-lg font-semibold text-white">
                  {{ item.text }}
                </h3>
              </div>
            </div>

            <div class="p-5">
              <div class="flex flex-wrap gap-2 mb-4">
                <span
                  v-for="(genre, index) in item.genre.split(',')"
                  :key="index"
                  class="px-3 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200"
                >
                  {{ genre.trim() }}
                </span>
              </div>

              <div class="space-y-3 text-sm">
                <div class="flex items-center">
                  <span class="w-20 text-gray-500 dark:text-gray-400">ID:</span>
                  <span class="font-mono">{{ item.id }}</span>
                </div>
                <div class="flex items-center">
                  <span class="w-20 text-gray-500 dark:text-gray-400"
                    >Cover:</span
                  >
                  <a
                    :href="item.img"
                    target="_blank"
                    class="text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300 underline truncate"
                  >
                    View Image
                  </a>
                </div>
                <div class="flex items-center">
                  <span class="w-20 text-gray-500 dark:text-gray-400"
                    >Poster:</span
                  >
                  <a
                    :href="item.poster"
                    target="_blank"
                    class="text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300 underline truncate"
                  >
                    View Image
                  </a>
                </div>
              </div>

              <div
                class="mt-5 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-2"
              >
                <!-- Edit button -->
                <button
                  @click="openEditForm(key, item)"
                  class="px-4 py-2 text-sm bg-yellow-50 dark:bg-yellow-900/30 hover:bg-yellow-100 dark:hover:bg-yellow-900/50 text-yellow-700 dark:text-yellow-300 rounded-lg transition-colors flex items-center gap-2"
                >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
</svg>
                   Edit
                </button>

                <!-- Delete button -->
                <button
                  @click="deleteBanner(key)"
                  class="px-4 py-2 text-sm bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 rounded-lg transition-colors flex items-center gap-2"
                >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Popup Modal -->
    <div
      v-if="editPopup"
      class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
    >
      <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-lg w-full p-6"
      >
        <h2 class="text-xl font-semibold mb-4">Edit Banner</h2>

        <form @submit.prevent="updateBanner" class="space-y-4">
          <span>Movie Title</span>
          <input
            v-model="editBanner.text"
            placeholder="Movie Title"
            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700"
            required
          />
          <span>Movie Genre</span>
          <input
            v-model="editBanner.genre"
            placeholder="Genre"
            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700"
            required
          />
          <span>Movie ID</span>
          <input
            v-model="editBanner.id"
            placeholder="Movie ID"
            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700"
            required
          />
          <span>Cover Image</span>
          <input
            v-model="editBanner.img"
            placeholder="Cover Image URL"
            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700"
            required
          />
          <span>Poster Image</span>
          <input
            v-model="editBanner.poster"
            placeholder="Poster Image URL"
            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700"
            required
          />

          <div class="flex justify-end gap-3 mt-4">
            <button
              type="button"
              @click="editPopup = false"
              class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white"
            >
              Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { rdb } from "@/firebase";
import { ref as dbRef, onValue, push, remove, update } from "firebase/database";

const banners = ref({});
const newBanner = ref({
  text: "",
  genre: "",
  id: "",
  img: "",
  poster: "",
});

// Edit state
const editPopup = ref(false);
const editKey = ref(null);
const editBanner = ref({
  text: "",
  genre: "",
  id: "",
  img: "",
  poster: "",
});

// Fetch banners
const fetchBanners = () => {
  const bannerRef = dbRef(rdb, "banner");
  onValue(bannerRef, (snapshot) => {
    banners.value = snapshot.val() || {};
  });
};

// Add new banner
const addBanner = async () => {
  const bannerRef = dbRef(rdb, "banner");
  await push(bannerRef, newBanner.value);
  newBanner.value = { text: "", genre: "", id: "", img: "", poster: "" };
};

// Delete banner
const deleteBanner = async (key) => {
  if (confirm("Are you sure you want to delete this banner?")) {
    const itemRef = dbRef(rdb, `banner/${key}`);
    await remove(itemRef);
  }
};

// Open edit form
const openEditForm = (key, item) => {
  editKey.value = key;
  editBanner.value = { ...item };
  editPopup.value = true;
};

// Update banner
const updateBanner = async () => {
  const itemRef = dbRef(rdb, `banner/${editKey.value}`);
  await update(itemRef, editBanner.value);
  editPopup.value = false;
};

onMounted(fetchBanners);
</script>
