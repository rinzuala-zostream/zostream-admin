<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6 text-gray-900 dark:text-white">
      <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
          <div>
            <h1 class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">Zostream Analytics</h1>
            <p class="text-gray-500 dark:text-gray-400">Real-time platform statistics</p>
          </div>
          <div class="flex items-center space-x-2">
            <span class="h-3 w-3 rounded-full bg-green-500 animate-pulse"></span>
            <span class="text-sm text-gray-500 dark:text-gray-400">Live Data</span>
          </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <!-- Movie Stats Cards -->
          <div
            v-for="(value, key) in movieStats"
            :key="key"
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow"
          >
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ formatKey(key) }}</p>
                <p class="mt-2 text-3xl font-bold">{{ value }}</p>
              </div>
              <div class="p-3 rounded-lg bg-indigo-50 dark:bg-indigo-900/30">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Subscription Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-8">
          <div class="flex items-center justify-between mb-6">
            <div>
              <h2 class="text-xl font-semibold">Subscriptions</h2>
              <p class="text-gray-500 dark:text-gray-400">User subscription analytics</p>
            </div>
            <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ totalSubscribed }}</div>
          </div>

          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div
              v-for="(count, plan) in subscriptionBreakdown"
              :key="plan"
              class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700"
            >
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ plan }}</p>
              <p class="mt-1 text-xl font-bold">{{ count }}</p>
            </div>
          </div>
        </div>

        <!-- User Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
              <div>
                <h2 class="text-xl font-semibold">Active Users</h2>
                <p class="text-gray-500 dark:text-gray-400">Currently engaged users</p>
              </div>
              <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ totalUsers }}</div>
            </div>
            <div class="h-40">
              <!-- Placeholder for chart -->
              <div class="flex items-end h-32 space-x-1 mt-4">
                <div v-for="i in 7" :key="i"
                  class="bg-green-500/20 w-8 rounded-t flex-1 hover:bg-green-500/30 transition-colors"
                  :style="`height: ${Math.random() * 100}%`"
                ></div>
              </div>
            </div>
          </div>

          <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
              <div>
                <h2 class="text-xl font-semibold">Firebase Users</h2>
                <p class="text-gray-500 dark:text-gray-400">Authentication statistics</p>
              </div>
              <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ firebaseUserCount ? firebaseUserCount.toLocaleString() : 'Loading...' }}</div>
            </div>
            <div class="h-40">
              <!-- Placeholder for chart -->
              <div class="flex items-end h-32 space-x-1 mt-4">
                <div v-for="i in 7" :key="i"
                  class="bg-blue-500/20 w-8 rounded-t flex-1 hover:bg-blue-500/30 transition-colors"
                  :style="`height: ${Math.random() * 100}%`"
                ></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
          <p>Last updated: {{ new Date().toLocaleString() }}</p>
        </div>
      </div>
    </div>
  </template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import axios from 'axios';

// Movie stats
const movieStats = reactive({
  total: 0,
  Hollywood: 0,
  Bollywood: 0,
  Mizo: 0,
  Korean: 0,
  PayPerView: 0,
  Premium: 0,
  AgeRestricted: 0,
  Documentary: 0,
  Protected: 0,
  Enable: 0,
  Series: 0,
});

// User stats
const totalUsers = ref(0);

// Firebase user count
const firebaseUserCount = ref(0);

// Subscription stats
const totalSubscribed = ref(0);
const subscriptionBreakdown = reactive({});

// Format labels
const formatKey = (key) => {
  return key
    .replace(/^is/, '')
    .replace(/([A-Z])/g, ' $1')
    .replace(/^./, str => str.toUpperCase());
};

// Fetch movie stats
const fetchMovies = async () => {
  try {
    const response = await axios.get(route('proxy.get', {
      endpoint: 'admin/movies',
    }));

    const data = response.data.data;
    movieStats.total = data.total_movies;

    // Reset all counters
    Object.keys(movieStats).forEach(k => {
      if (k !== 'total') movieStats[k] = 0;
    });

    const categories = data.movies_by_category || {};
    for (const [key, value] of Object.entries(categories)) {
      const normalizedKey = key.replace(/\s+/g, ''); // e.g. 'Age Restricted' -> 'AgeRestricted'
      if (normalizedKey in movieStats) {
        movieStats[normalizedKey] = value;
      }
    }
  } catch (error) {
    console.error('Error fetching movies:', error);
  }
};

// Fetch user count
const fetchUsers = async () => {
  try {
    const response = await axios.get(route('proxy.get', {
      endpoint: 'admin/users',
    }));

    totalUsers.value = response.data.data.total_users || 0;
  } catch (error) {
    console.error('Error fetching users:', error);
  }
};

// Fetch subscription data
const fetchSubs = async () => {
  try {
    const response = await axios.get(route('proxy.get', {
      endpoint: 'admin/subscriptions',
      device_type: 'Browser'
    }));

    const data = response.data.data;
    totalSubscribed.value = data.total_subscribed_users || 0;

    const subs = data.subscriptions || {};
    Object.keys(subscriptionBreakdown).forEach(k => delete subscriptionBreakdown[k]); // Reset
    for (const [plan, count] of Object.entries(subs)) {
      subscriptionBreakdown[plan] = count;
    }
  } catch (error) {
    console.error('Error fetching subscriptions:', error);
  }
};

// Firebase user count from Laravel
const fetchFirebaseUserCount = async () => {
  try {
    const res = await axios.get(route('count'));
    firebaseUserCount.value = res.data.count;
  } catch (e) {
    console.error('Failed to fetch Firebase user count', e);
  }
};

onMounted(() => {
  fetchMovies();
  fetchUsers();
  fetchSubs();
  fetchFirebaseUserCount();
});
</script>


  <style scoped>
  /* Optional: Add some transitions or color schemes */
  </style>
