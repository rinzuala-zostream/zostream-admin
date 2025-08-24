<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors text-gray-900 dark:text-gray-100">
      <!-- Header -->
      <header class="sticky top-0 z-10 backdrop-blur-sm bg-white dark:bg-gray-900 bg-opacity-80 border-b border-gray-200 dark:border-gray-700 transition-colors">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
          <h1 class="text-2xl font-bold flex items-center gap-2">
            <span class="text-blue-500">📊</span>
            <span>ZoStream Polls</span>
          </h1>
        </div>
      </header>

      <main class="max-w-6xl mx-auto px-4 py-8">
        <!-- Create Poll Card -->
        <div class="mb-10 rounded-xl shadow-lg overflow-hidden bg-white dark:bg-gray-800 transition-all duration-300 hover:shadow-xl">
          <div class="p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="text-blue-500">✨</span><span>Create New Poll</span></h2>
            <form @submit.prevent="createPoll" class="space-y-4">
              <div><label class="block mb-1 font-medium">Question</label><input v-model="newPoll.question" type="text" placeholder="What's your poll question?" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 transition-all" required /></div>
              <div class="flex items-center"><label class="flex items-center cursor-pointer"><div class="relative"><input type="checkbox" v-model="newPoll.status" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 transition-all" /><div class="w-10 h-4 bg-gray-300 dark:bg-gray-700 rounded-full shadow-inner"></div><div class="dot absolute w-6 h-6 rounded-full shadow -left-1 -top-1 transition" :class="{'bg-blue-500 transform translate-x-6': newPoll.status, 'bg-gray-400': !newPoll.status}"></div></div><div class="ml-3 font-medium">Active Poll</div></label></div>
              <div class="space-y-3"><label class="block font-medium">Options</label><div v-for="(option, index) in newPoll.options" :key="index" class="p-4 rounded-lg bg-gray-100 dark:bg-gray-700 transition-all"><div class="grid grid-cols-1 md:grid-cols-2 gap-3"><div><label class="block text-sm mb-1">Label</label><input v-model="option.label" type="text" :placeholder="`Option ${index + 1}`" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 transition-all" required /></div><div><label class="block text-sm mb-1">Image URL (optional)</label><input v-model="option.image" type="text" placeholder="https://example.com/image.jpg" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 transition-all" /></div></div><button @click.prevent="removeOption(index)" class="mt-2 text-sm flex items-center text-red-500 hover:text-red-600 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>Remove</button></div></div>
              <button @click.prevent="addOption" class="flex items-center text-blue-500 hover:text-blue-600 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>Add Option</button>
              <button type="submit" class="w-full mt-4 py-3 px-6 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-md transition-all transform hover:scale-[1.02]">Create Poll</button>
            </form>
          </div>
        </div>

        <!-- Polls List -->
        <div v-if="polls.length === 0" class="text-center py-10"><p class="text-lg">No polls created yet</p></div>
        <div v-else class="space-y-6">
          <h2 class="text-xl font-semibold flex items-center gap-2"><span class="text-blue-500">📋</span><span>Your Polls</span></h2>
          <div v-for="poll in polls" :key="poll.id" class="rounded-xl shadow-lg overflow-hidden bg-white dark:bg-gray-800 transition-all duration-300 hover:shadow-xl">
            <div class="p-6">
              <!-- Poll Header -->
              <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                <h3 class="text-lg font-semibold">{{ poll.data.question }}</h3>
                <div class="flex items-center gap-4">
                  <!-- NEW: Status Toggle Switch -->
                  <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium" :class="poll.data.status ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'">
                      {{ poll.data.status ? 'Active' : 'Inactive' }}
                    </span>
                    <label :for="`status-toggle-${poll.id}`" class="flex items-center cursor-pointer">
                      <div class="relative">
                        <input :id="`status-toggle-${poll.id}`" type="checkbox" class="sr-only" :checked="poll.data.status" @change="togglePollStatus(poll)" />
                        <div class="block bg-gray-200 dark:bg-gray-700 w-12 h-6 rounded-full transition-colors"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform"
                             :class="{ 'transform translate-x-6 bg-blue-500': poll.data.status }"></div>
                      </div>
                    </label>
                  </div>
                  <button @click="deletePoll(poll.id)" class="p-2 rounded-full hover:bg-red-500/10 text-red-500 hover:text-red-600 transition-colors" title="Delete Poll">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                  </button>
                </div>
              </div>
              
              <!-- Poll Options (unchanged) -->
              <div class="space-y-3">
                <div v-for="(label, key) in poll.data.options" :key="key" class="p-4 rounded-lg bg-gray-100 dark:bg-gray-700 transition-all">
                  <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                      <div class="relative"><img :src="poll.data.image?.[key] || 'https://via.placeholder.com/100x100?text=Option'" alt="Option image" class="w-12 h-12 rounded-lg object-cover"><div v-if="poll.data.votes?.[key]?.length" class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-8 flex items-center justify-center">{{ poll.data.votes?.[key]?.length }}</div></div>
                      <span class="font-medium">{{ label }}</span>
                    </div>
                    <button @click="toggleVoters(poll.id, key)" class="text-sm flex items-center gap-1 px-3 py-1 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" :class="{'rotate-180': expandedVoters[`${poll.id}-${key}`]}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg></button>
                  </div>
                  <div v-if="expandedVoters[`${poll.id}-${key}`]" class="mt-3 pt-3 border-t border-gray-300 dark:border-gray-600"><h4 class="text-sm font-medium mb-2">Voters ({{ poll.data.votes?.[key]?.length || 0 }})</h4><div v-if="poll.data.votes?.[key]?.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2"><div v-for="(uid, index) in poll.data.votes?.[key]" :key="index" class="text-sm px-3 py-1 rounded-full flex items-center gap-2 bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-100"><span class="truncate">{{ uid }}</span></div></div><p v-else class="text-sm text-gray-500 dark:text-gray-400">No votes yet</p></div>
                </div>
              </div>

              <!-- Poll Meta (unchanged) -->
              <div class="mt-4 pt-4 text-sm flex justify-between items-center border-t border-gray-200 dark:border-gray-700"><span>Created: {{ poll.data.createdAt }}</span><span class="font-medium">Total Votes: {{ countTotalVotes(poll.data.votes) }}</span></div>
            </div>
          </div>
        </div>

        <!-- Notification (unchanged) -->
        <transition name="fade"><div v-if="message" class="fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>{{ message }}</div></transition>
      </main>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue'
  import { db } from '@/firebase'
  import {
    collection,
    getDocs,
    deleteDoc,
    doc,
    addDoc,
    updateDoc
  } from 'firebase/firestore'
import { toast } from 'vue3-toastify'

  const polls = ref([])
  const message = ref('')
  const expandedVoters = ref({})
  const newPoll = ref({
    question: '',
    status: true,
    options: [
      { label: '', image: '' },
      { label: '', image: '' }
    ]
  })

  // NEW: Function to toggle a poll's status
  const togglePollStatus = async (poll) => {
    const originalStatus = poll.data.status;
    // Optimistic UI update for a snappy feel
    poll.data.status = !poll.data.status; 
    try {
      const pollRef = doc(db, 'polls', poll.id);
      await updateDoc(pollRef, {
        status: poll.data.status
      });
      message.value = `Poll status updated to ${poll.data.status ? 'Active' : 'Inactive'}`;
      setTimeout(() => message.value = '', 3000);
    } catch (error) {
      // Revert the change on error
      poll.data.status = originalStatus; 
      message.value = 'Error updating poll status';
      console.error('Error updating status:', error);
    }
  };

  const fetchPolls = async () => {
    const pollCollection = collection(db, 'polls')
    const snapshot = await getDocs(pollCollection)
    polls.value = snapshot.docs.map(doc => ({
      id: doc.id,
      data: doc.data()
    }))
  }

  const createPoll = async () => {
    try {
      const options = {}
      const image = {}
      const votes = {}

      newPoll.value.options.forEach((opt, i) => {
        const key = `option${i + 1}`
        options[key] = opt.label
        image[key] = opt.image
        votes[key] = []
      })

      await addDoc(collection(db, 'polls'), {
        question: newPoll.value.question,
        status: newPoll.value.status,
        options,
        image,
        votes,
        createdAt: new Date().toLocaleDateString('en-US', {
          month: 'short',
          day: 'numeric',
          year: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        })
      })

      message.value = 'Poll created successfully!'
      toast.success('Poll created successfully!')
      setTimeout(() => message.value = '', 3000)

      // Reset form
      newPoll.value = {
        question: '',
        status: true,
        options: [
          { label: '', image: '' },
          { label: '', image: '' }
        ]
      }

      await fetchPolls()
    } catch (error) {
      message.value = 'Error creating poll'
      console.error(error)
    }
  }

  const deletePoll = async (pollId) => {
    if (!confirm('Are you sure you want to delete this poll?')) return

    try {
      await deleteDoc(doc(db, 'polls', pollId))
      message.value = 'Poll deleted successfully'
      setTimeout(() => message.value = '', 3000)
      await fetchPolls()
    } catch (error) {
      message.value = 'Error deleting poll'
      console.error(error)
    }
  }

  const addOption = () => {
    newPoll.value.options.push({ label: '', image: '' })
  }

  const removeOption = (index) => {
    if (newPoll.value.options.length > 2) {
      newPoll.value.options.splice(index, 1)
    }
  }

  const toggleVoters = (pollId, optionKey) => {
    const key = `${pollId}-${optionKey}`
    expandedVoters.value[key] = !expandedVoters.value[key]
  }

  const countTotalVotes = (votes) => {
    if (!votes) return 0
    return Object.values(votes).reduce((total, arr) => total + (arr?.length || 0), 0)
  }

  onMounted(fetchPolls)
  </script>

  <style>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s ease;
  }

  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }

  .dot {
    transition: all 0.3s ease-in-out;
  }
  </style>
