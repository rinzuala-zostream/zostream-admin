<template>
  <div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
      <!-- Header and Add Button -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
          <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Ad Management</h2>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Display and manage all ad campaigns.</p>
        </div>
        <button @click="openAddModal" class="mt-4 sm:mt-0 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <svg class="w-5 h-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
          Add New Ad
        </button>
      </div>

      <!-- Main Content Area -->
      <div v-if="isLoading" class="text-center p-12">
        <svg class="animate-spin mx-auto h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
        <p class="mt-2 text-gray-500 dark:text-gray-400">Loading ads...</p>
      </div>
      <div v-else-if="error" class="text-center p-12 text-red-500 bg-red-50 dark:bg-red-900/20 rounded-lg">{{ error }}</div>
      <div v-else-if="allAds.length === 0" class="text-center p-12 text-gray-500 dark:text-gray-400"><p>No advertisements found.</p></div>
      <div v-else>
        <!-- Ad Card Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
          <div v-for="ad in paginatedAds" :key="ad.num" class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col transition-transform hover:scale-105 duration-300">
            <img v-if="ad.feature_img" :src="ad.feature_img" class="h-48 w-full object-cover">
            <div v-else class="h-48 w-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">No Image</div>
            <div class="p-4 flex-grow flex flex-col">
              <span class="text-xs font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">{{ ad.type }}</span>
              <h3 class="mt-1 text-lg font-bold text-gray-900 dark:text-gray-100 flex-grow">{{ ad.ads_name }}</h3>
              <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Runs for <span class="font-medium">{{ ad.period }}</span> days</p>
            </div>
            <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-2">
              <button @click="openEditModal(ad.num)" class="px-3 py-1 text-sm font-medium rounded-md text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/50">Edit</button>
              <button @click="openDeleteModal(ad.num)" class="px-3 py-1 text-sm font-medium rounded-md text-red-600 hover:bg-red-100 dark:hover:bg-red-900/50">Delete</button>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="pagination.total > pagination.per_page" class="mt-8 flex items-center justify-between">
          <div class="text-sm text-gray-700 dark:text-gray-400">
            Showing <span class="font-semibold">{{ pageFrom }}</span> to <span class="font-semibold">{{ pageTo }}</span> of <span class="font-semibold">{{ pagination.total }}</span> results
          </div>
          <Pagination v-model:page="pagination.current_page" :total="pagination.total" :items-per-page="pagination.per_page" :sibling-count="1" show-edges>
            <PaginationContent v-slot="{ items }" class="flex items-center gap-1">
              <PaginationPrevious /><template v-for="(item, index) in items"><PaginationItem v-if="item.type === 'page'" :key="index" :value="item.value">{{ item.value }}</PaginationItem><PaginationEllipsis v-else :key="item.type" :index="index" /></template><PaginationNext />
            </PaginationContent>
          </Pagination>
        </div>
      </div>
    </div>

    <!-- Modals -->
    <AdAddModal :is-visible="showAddModal" @close="closeAddModal" @saved="handleAdSaved" />
    <AdUpdateModal :is-visible="showEditModal" :ad-id="editingAdId" @close="closeEditModal" @saved="handleAdSaved" />
    
    <Teleport to="body">
      <transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div v-if="showDeleteModal" class="relative z-50">
          <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
          <div class="fixed inset-0 z-10 w-screen overflow-y-auto"><div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"><transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95"><div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl sm:my-8 sm:w-full sm:max-w-lg"><div class="bg-white dark:bg-gray-800 px-4 pb-4 pt-5 sm:p-6 sm:pb-4"><div class="sm:flex sm:items-start"><div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/50 sm:mx-0 sm:h-10 sm:w-10"><ExclamationTriangleIcon class="h-6 w-6 text-red-600 dark:text-red-400" /></div><div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left"><h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">Delete Ad</h3><div class="mt-2"><p class="text-sm text-gray-500 dark:text-gray-400">Are you sure? This cannot be undone.</p></div></div></div></div><div class="bg-gray-50 dark:bg-gray-800/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"><button @click="confirmDelete" :disabled="isDeleting" type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto disabled:opacity-50"><span v-if="isDeleting">Deleting...</span><span v-else>Delete</span></button><button @click="closeDeleteModal" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 sm:mt-0 sm:w-auto">Cancel</button></div></div></transition></div></div>
        </div>
      </transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, onMounted, reactive, watch, computed } from 'vue';
import axios from 'axios';
import { toast } from 'vue3-toastify';
import { Pagination, PaginationContent, PaginationEllipsis, PaginationItem, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import AdAddModal from './adsAddCom.vue';
import AdUpdateModal from './adsEditCom.vue';

const allAds = ref([]);
const isLoading = ref(true);
const error = ref(null);

const pagination = reactive({ current_page: 1, per_page: 15, total: 0 });

const paginatedAds = computed(() => {
  const start = (pagination.current_page - 1) * pagination.per_page;
  const end = start + pagination.per_page;
  return allAds.value.slice(start, end);
});
const pageFrom = computed(() => allAds.value.length === 0 ? 0 : (pagination.current_page - 1) * pagination.per_page + 1);
const pageTo = computed(() => Math.min(pagination.current_page * pagination.per_page, pagination.total));

const showAddModal = ref(false);
const showEditModal = ref(false);
const editingAdId = ref(null);
const showDeleteModal = ref(false);
const deletingAdId = ref(null);
const isDeleting = ref(false);

const fetchAds = async () => {
  isLoading.value = true;
  error.value = null;
  try {
    const response = await axios.get(route('proxy.get'), { params: { endpoint: 'ads' } });
    // Based on example, response.data is the array
    if (Array.isArray(response.data)) {
      allAds.value = response.data;
      pagination.total = allAds.value.length;
    } else {
      throw new Error("Invalid API response format");
    }
  } catch (err) {
    error.value = "Failed to fetch advertisements.";
  } finally {
    isLoading.value = false;
  }
};

watch(() => pagination.current_page, () => window.scrollTo({ top: 0, behavior: 'smooth' }));

const openAddModal = () => showAddModal.value = true;
const closeAddModal = () => showAddModal.value = false;
const openEditModal = (id) => { editingAdId.value = id; showEditModal.value = true; };
const closeEditModal = () => { editingAdId.value = null; showEditModal.value = false; };
const openDeleteModal = (id) => { deletingAdId.value = id; showDeleteModal.value = true; };
const closeDeleteModal = () => { deletingAdId.value = null; showDeleteModal.value = false; };

const handleAdSaved = () => {
  closeAddModal();
  closeEditModal();
  fetchAds();
};

const confirmDelete = async () => {
  if (!deletingAdId.value) return;
  isDeleting.value = true;
  try {
    await axios.delete(route('proxy.delete', { endpoint: `ads/${deletingAdId.value}` }));
    toast.success("Ad deleted successfully!");
    if (paginatedAds.value.length === 1 && pagination.current_page > 1) {
      pagination.current_page--;
    }
    fetchAds();
  } catch (err) {
    toast.error("Failed to delete ad.");
  } finally {
    isDeleting.value = false;
    closeDeleteModal();
  }
};

onMounted(fetchAds);
</script>