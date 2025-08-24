<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-4 md:p-6 transition-colors">
    <div class="max-w-6xl mx-auto">
      <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white mb-6">Reports Management</h1>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
      </div>

      <!-- Empty State -->
      <div v-else-if="allReports.length === 0" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
        <p class="text-gray-600 dark:text-gray-300">No reports found.</p>
      </div>

      <!-- Reports List -->
      <div v-else>
        <div class="space-y-4">
          <!-- CHANGE: v-for now iterates over the computed `paginatedReports` -->
          <div
            v-for="report in paginatedReports"
            :key="report.id"
            class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden transition-all duration-200"
            :class="{ 'ring-2 ring-blue-500': expandedReport === report.id }"
          >
            <!-- Report Summary -->
            <div
              class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
              @click="toggleReport(report.id)"
            >
              <div class="flex items-center space-x-3 mb-2 sm:mb-0">
                <span class="font-medium text-gray-900 dark:text-white">{{ report.hming }}</span>
                <span
                  class="px-2 py-1 text-xs rounded-full"
                  :class="{
                    'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200': report.achhan === 'ADANG',
                    'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200': report.achhan !== 'ADANG'
                  }"
                >
                  {{ report.achhan }}
                </span>
              </div>

              <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">
                  {{ formatDate(report.date) }}
                </span>
                <span
                  class="px-2 py-1 text-xs rounded-full font-medium"
                  :class="{
                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': report.isApprove,
                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200': !report.isApprove
                  }"
                >
                  {{ report.isApprove ? 'Approved' : 'Pending' }}
                </span>
                <span class="text-gray-500 dark:text-gray-400 text-sm">
                  {{ expandedReport === report.id ? '▼' : '▶' }}
                </span>
              </div>
            </div>

            <!-- Report Details (Expanded) - No changes needed inside here -->
            <div v-if="expandedReport === report.id" class="border-t border-gray-200 dark:border-gray-700 p-4 space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div><p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p><p class="text-gray-900 dark:text-white">{{ report.mail }}</p></div>
                <div><p class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</p><p class="text-gray-900 dark:text-white">{{ report.phone }}</p></div>
                <div><p class="text-sm font-medium text-gray-500 dark:text-gray-400">Report Date</p><p class="text-gray-900 dark:text-white">{{ formatDate(report.date) }}</p></div>
                <div><p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p><p class="font-medium" :class="{'text-green-600 dark:text-green-400': report.isApprove,'text-yellow-600 dark:text-yellow-400': !report.isApprove}">{{ report.isApprove ? 'Approved' : 'Pending' }}</p></div>
              </div>
              <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4"><h3 class="font-medium text-gray-900 dark:text-white mb-2">Report Message</h3><p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ report.sawizauna }}</p></div>
              <div v-if="report.msg" class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4"><h3 class="font-medium text-blue-800 dark:text-blue-200 mb-2">Your Response</h3><p class="text-blue-700 dark:text-blue-300 whitespace-pre-wrap">{{ report.msg }}</p></div>
              <div class="space-y-3"><h3 class="font-medium text-gray-900 dark:text-white">Reply to Reporter</h3><textarea v-model="report.responseDraft" placeholder="Enter your response..." rows="4" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea><div class="flex flex-wrap gap-2"><button @click.stop="toggleApproval(report)" :disabled="report.updatingStatus" class="px-4 py-2 rounded-md font-medium flex items-center" :class="[{'bg-green-600 hover:bg-green-700 text-white': !report.isApprove, 'bg-red-600 hover:bg-red-700 text-white': report.isApprove, 'opacity-70 cursor-not-allowed': report.updatingStatus}]"><span>{{ report.isApprove ? 'Reject' : 'Approve' }}</span><svg v-if="report.updatingStatus" class="animate-spin -mr-1 ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></button><button @click.stop="submitResponse(report)" :disabled="!report.responseDraft.trim() || report.updatingResponse" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium flex items-center" :class="{'opacity-70 cursor-not-allowed': !report.responseDraft.trim() || report.updatingResponse}"><span>Send Response</span><svg v-if="report.updatingResponse" class="animate-spin -mr-1 ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></button><button v-if="report.isApprove && report.msg" @click.stop="deleteReport(report)" :disabled="report.deleting" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-medium flex items-center ml-auto" :class="{ 'opacity-70 cursor-not-allowed': report.deleting }"><span>Delete Report</span><svg v-if="report.deleting" class="animate-spin -mr-1 ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></button></div>
              </div>
            </div>
          </div>
        </div>
        <!-- NEW: Pagination Controls -->
        <div v-if="pagination.total > pagination.per_page" class="mt-8 flex items-center justify-between">
          <div class="text-sm text-gray-700 dark:text-gray-400">
            Showing <span class="font-semibold">{{ pageFrom }}</span> to <span class="font-semibold">{{ pageTo }}</span> of <span class="font-semibold">{{ pagination.total }}</span> results
          </div>
          <Pagination v-model:page="pagination.current_page" :total="pagination.total" :items-per-page="pagination.per_page" :sibling-count="1" show-edges>
            <PaginationContent v-slot="{ items }" class="flex items-center gap-1">
              <PaginationPrevious />
              <template v-for="(item, index) in items">
                <PaginationItem v-if="item.type === 'page'" :key="index" :value="item.value">{{ item.value }}</PaginationItem>
                <PaginationEllipsis v-else :key="item.type" :index="index" />
              </template>
              <PaginationNext />
            </PaginationContent>
          </Pagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, reactive, computed } from 'vue';
import { db } from '@/firebase';
import { collection, getDocs, updateDoc, doc, serverTimestamp, deleteDoc } from 'firebase/firestore';
import { Pagination, PaginationContent, PaginationEllipsis, PaginationItem, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';

const loading = ref(true);
const allReports = ref([]); // CHANGE: This holds the full list from Firestore
const expandedReport = ref(null);

// NEW: Pagination state
const pagination = reactive({
  current_page: 1,
  per_page: 15,
  total: 0,
});

// NEW: Computed property to get the reports for the current page
const paginatedReports = computed(() => {
  const start = (pagination.current_page - 1) * pagination.per_page;
  const end = start + pagination.per_page;
  return allReports.value.slice(start, end);
});

// NEW: Computed properties for "Showing X to Y"
const pageFrom = computed(() => allReports.value.length === 0 ? 0 : (pagination.current_page - 1) * pagination.per_page + 1);
const pageTo = computed(() => Math.min(pagination.current_page * pagination.per_page, pagination.total));

// Fetch all reports from Firestore
const fetchReports = async () => {
  try {
    loading.value = true;
    const querySnapshot = await getDocs(collection(db, 'report'));
    // CHANGE: Store fetched data in the master list
    allReports.value = querySnapshot.docs.map(doc => ({
      id: doc.id,
      ...doc.data(),
      responseDraft: doc.data().msg || '',
      updatingStatus: false,
      updatingResponse: false,
      deleting: false
    }));
    // CHANGE: Update pagination total
    pagination.total = allReports.value.length;
  } catch (error) {
    console.error('Error fetching reports:', error);
  } finally {
    loading.value = false;
  }
};

const toggleReport = (reportId) => {
  expandedReport.value = expandedReport.value === reportId ? null : reportId;
};

const toggleApproval = async (report) => {
  try {
    report.updatingStatus = true;
    const reportRef = doc(db, 'report', report.id);
    await updateDoc(reportRef, {
      isApprove: !report.isApprove,
      updatedAt: serverTimestamp()
    });
    report.isApprove = !report.isApprove;
  } catch (error) {
    console.error('Error updating approval status:', error);
  } finally {
    report.updatingStatus = false;
  }
};

const submitResponse = async (report) => {
  if (!report.responseDraft.trim()) return;
  try {
    report.updatingResponse = true;
    const reportRef = doc(db, 'report', report.id);
    await updateDoc(reportRef, {
      msg: report.responseDraft,
      updatedAt: serverTimestamp(),
      respondedAt: serverTimestamp(),
      isApprove: report.isApprove
    });
    report.msg = report.responseDraft;
  } catch (error) {
    console.error('Error submitting response:', error);
  } finally {
    report.updatingResponse = false;
  }
};

// CHANGE: Updated delete logic for pagination
const deleteReport = async (report) => {
  if (!confirm('Are you sure you want to delete this report? This action cannot be undone.')) return;
  try {
    report.deleting = true;
    const reportRef = doc(db, 'report', report.id);
    await deleteDoc(reportRef);
    
    // Smartly adjust current page if the last item on it was deleted
    if (paginatedReports.value.length === 1 && pagination.current_page > 1) {
        pagination.current_page--;
    }

    // Refresh the entire list from Firestore
    await fetchReports();
  } catch (error) {
    console.error('Error deleting report:', error);
  } finally {
    // This is handled by the fetch, but good for safety
    report.deleting = false; 
  }
};

const formatDate = (dateString) => dateString || 'N/A';

onMounted(() => {
  fetchReports();
});
</script>