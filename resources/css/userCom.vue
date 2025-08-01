<template>
  <div class="max-w-xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6 text-center">User Operations</h1>

    <!-- Toggle Buttons -->
    <div class="flex justify-center gap-3 mb-6">
      <button @click="activeTab = 'search'" :class="buttonClass('search')">
        Search User
      </button>
      <button @click="activeTab = 'register'" :class="buttonClass('register')">
        Register User
      </button>
      <button @click="activeTab = 'update'" :class="buttonClass('update')">
        Update DOB
      </button>
    </div>

    <!-- Search Section -->
    <div v-if="activeTab === 'search'">
      <div class="flex items-center gap-3 mb-4">
        <input v-model="input" type="text" placeholder="Enter email or UID"
          class="flex-1 px-4 py-2 border rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
        <button @click="fetchUser" :disabled="loading || !input"
          class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 disabled:opacity-50">
          Search
        </button>
      </div>

      <div class="flex justify-center mb-6">
      <button
        @click="insertUidFromCache"
        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-sm rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600"
      >
        Insert UID from Cache
      </button>
    </div>

      <div v-if="loading" class="text-center text-gray-500">Loading...</div>
      <div v-if="error" class="text-red-600 text-center mb-4">{{ error }}</div>

      <hr class="my-6 border-t border-gray-300 dark:border-gray-700" />

       <!-- Display Multiple Users -->
       <div v-if="users.length > 0" class="space-y-6">
        <div v-for="user in users" :key="user.uid" class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
          <h2 class="text-xl font-bold mb-4 text-center">User Details</h2>
          <ul class="text-gray-800 dark:text-gray-100 space-y-2">
            <li v-for="(value, key) in user" :key="key" class="flex justify-between border-b pb-1 gap-4">
              <span class="font-medium capitalize">{{ key.replace(/_/g, ' ') }}:</span>
              <span class="text-right break-words whitespace-pre-wrap max-w-full">
                {{ value || 'N/A' }}
              </span>
            </li>
          </ul>
          <div class="text-center mt-6 flex justify-center gap-4">
            <button @click="openEditModal(user)"
              class="px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
              Edit Profile
            </button>
            <button @click="promptDelete(user)"
              class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700">
              Delete User
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Register Section -->
<div v-if="activeTab === 'register'" class="mt-4 space-y-4">
  <input v-model="form.name" type="text" placeholder="Name"
    class="w-full px-4 py-2 border rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" />

  <input v-model="form.email" type="email" placeholder="Email"
    class="w-full px-4 py-2 border rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" />

  <div class="relative">
    <input :type="showPassword ? 'text' : 'password'" v-model="form.password" placeholder="Password"
      class="w-full px-4 py-2 border rounded-xl shadow-sm pr-12 focus:outline-none focus:ring-2 focus:ring-green-500" />
    <span @click="showPassword = !showPassword" class="absolute right-4 top-3 cursor-pointer text-gray-600">
      {{ showPassword ? '🙈' : '👁️' }}
    </span>
  </div>

  <div class="relative">
    <input :type="showConfirmPassword ? 'text' : 'password'" v-model="form.confirmPassword" placeholder="Confirm Password"
      class="w-full px-4 py-2 border rounded-xl shadow-sm pr-12 focus:outline-none focus:ring-2 focus:ring-green-500" />
    <span @click="showConfirmPassword = !showConfirmPassword" class="absolute right-4 top-3 cursor-pointer text-gray-600">
      {{ showConfirmPassword ? '🙈' : '👁️' }}
    </span>
  </div>

  <button @click="registerUser" :disabled="loading || !form.email || !form.password"
    class="w-full px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 disabled:opacity-50">
    Register
  </button>

  <hr class="my-6 border-t border-gray-300 dark:border-gray-700" />

  <div v-if="registerResult" class="mt-4 text-center text-green-600">{{ registerResult }}</div>
  <div v-if="registerError" class="mt-4 text-center text-red-600">{{ registerError }}</div>
</div>

    <!-- Update DOB Section -->
    <div v-if="activeTab === 'update'" class="mt-4">
      <div class="mb-4">
        <input v-model="updateUid" type="text" placeholder="Enter UID"
          class="w-full px-4 py-2 border rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500" />
      </div>
      <div class="flex justify-center mb-6">
      <button
        @click="insertUidFromCache"
        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-sm rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600"
      >
        Insert UID from Cache
      </button>
    </div>
      <div class="mb-4">
        <input v-model="newDob" type="date"
          class="w-full px-4 py-2 border rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500" />
      </div>
      <button @click="updateDOB" :disabled="loading || !newDob"
        class="w-full px-4 py-2 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 disabled:opacity-50">
        Update DOB
      </button>

      <hr class="my-6 border-t border-gray-300 dark:border-gray-700" />

      <div v-if="updateResult" class="mt-4 text-center text-green-600">{{ updateResult }}</div>
      <div v-if="updateError" class="mt-4 text-center text-red-600">{{ updateError }}</div>
    </div>
  </div>

  <!-- Modal -->
  <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 w-full max-w-md p-6 rounded-xl shadow-xl">
      <h3 class="text-lg font-semibold mb-4 text-center">Edit User Profile</h3>

      <div class="space-y-3">
        <div>
          <label class="block text-sm font-medium">UID</label>
          <input v-model="editForm.uid" type="text" disabled
            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600" />
        </div>

        <div>
          <label class="block text-sm font-medium">Name</label>
          <input v-model="editForm.name" type="text" class="w-full px-3 py-2 border rounded-md" />
        </div>

        <div>
          <label class="block text-sm font-medium">Veng</label>
          <input v-model="editForm.veng" type="text" class="w-full px-3 py-2 border rounded-md" />
        </div>

        <div>
          <label class="block text-sm font-medium">Khua</label>
          <input v-model="editForm.khua" type="text" class="w-full px-3 py-2 border rounded-md" />
        </div>

        <div>
          <label class="block text-sm font-medium">Call</label>
          <input v-model="editForm.call" type="text" class="w-full px-3 py-2 border rounded-md" />
        </div>

        <div>
          <label class="block text-sm font-medium">Edit Date</label>
          <input v-model="editForm.edit_date" type="date" class="w-full px-3 py-2 border rounded-md" />
        </div>

        <div class="flex items-center space-x-2">
          <input type="checkbox" v-model="editForm.isAccountComplete" id="isAccountComplete" class="rounded" />
          <label for="isAccountComplete" class="text-sm">Is Account Complete?</label>
        </div>
      </div>

      <div class="mt-6 flex justify-between">
        <button @click="submitEditForm" class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700">
          Save
        </button>
        <button @click="showEditModal = false" class="px-4 py-2 bg-gray-400 text-white rounded-xl hover:bg-gray-500">
          Cancel
        </button>
      </div>
    </div>
      <!-- Delete Confirmation Modal -->
  <div v-if="showDeleteConfirm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 w-full max-w-md p-6 rounded-xl shadow-xl">
      <h3 class="text-lg font-semibold mb-4 text-center">Confirm Deletion</h3>
      <p class="text-center mb-4">
        Are you sure you want to delete this user?
        <span v-if="userToDelete" class="font-bold block mt-2">{{ userToDelete.name }} ({{ userToDelete.mail }})</span>
      </p>
      <div v-if="deleteError" class="text-red-600 text-center mb-4">{{ deleteError }}</div>
      <div class="mt-6 flex justify-around">
        <button @click="confirmDelete" :disabled="loading"
          class="px-6 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 disabled:opacity-50">
          {{ loading ? 'Deleting...' : 'Confirm' }}
        </button>
        <button @click="showDeleteConfirm = false" :disabled="loading"
          class="px-6 py-2 bg-gray-400 text-white rounded-xl hover:bg-gray-500 disabled:opacity-50">
          Cancel
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { getAuth, createUserWithEmailAndPassword } from 'firebase/auth'

const form = ref({
  name: '',
  email: '',
  password: '',
  confirmPassword: ''
})

const showPassword = ref(false)
const showConfirmPassword = ref(false)

const activeTab = ref('search')

const input = ref('')
const user = ref(null)
const error = ref('')
const loading = ref(false)

const registerEmail = ref('')
const registerResult = ref('')
const registerError = ref('')

const updateUid = ref('')
const newDob = ref('')
const updateResult = ref('')
const updateError = ref('')
const showEditModal = ref(false)

// Modal states
const showEditModal = ref(false)
const showDeleteConfirm = ref(false)
const userToDelete = ref(null)
const deleteError = ref('')

const editForm = ref({
  uid: '',
  name: '',
  veng: '',
  khua: '',
  call: '',
  edit_date: '',
  isAccountComplete: false,
})

const fetchUser = async () => {
  error.value = ''
  users.value = [] // Clear previous results
  loading.value = true

  try {
    const res = await axios.get(route('proxy.get'), {
      params: {
        endpoint: 'user',
        mail: input.value.includes('@') ? input.value : undefined,
        uid: !input.value.includes('@') ? input.value : undefined,
      },
    })

    const responseData = res.data
    if (!responseData || (Array.isArray(responseData) && responseData.length === 0) || responseData.error) {
      throw new Error(responseData.message || 'User not found.')
    }

    // Standardize results to an array
    const results = Array.isArray(responseData) ? responseData : [responseData]

    // Exclude 'token' from each user object
    users.value = results.map(u => {
      const { token, ...filteredUser } = u
      return filteredUser
    })

    // Store Uid in sessionStorage only if one user is found
    if (users.value.length === 1 && users.value[0].uid) {
      sessionStorage.setItem('searchedUserUid', users.value[0].uid)
    } else {
      sessionStorage.removeItem('searchedUserUid')
    }

  } catch (err) {
    error.value = err.response?.data?.message || err.message
    sessionStorage.removeItem('searchedUserUid')
  } finally {
    loading.value = false
  }
}

const openEditModal = () => {
  if (!user.value) return
  const today = new Date().toISOString().split('T')[0]
  editForm.value = {
    uid: user.value.uid || '',
    name: user.value.name || '',
    veng: user.value.veng || '',
    khua: user.value.khua || '',
    call: user.value.call || '',
    edit_date: today,
    isAccountComplete: !!user.value.isAccountComplete,
  }
  showEditModal.value = true
}

const submitEditForm = async () => {
  const body = {
    uid: editForm.value.uid,
    name: editForm.value.name,
    veng: editForm.value.veng,
    khua: editForm.value.khua,
    call: editForm.value.call,
    edit_date: editForm.value.edit_date,
    isAccountComplete: editForm.value.isAccountComplete ? 1 : 0,
  }

  try {
    await axios.post(route('proxy.post'), body, {
      params: {
        endpoint: 'update-profile', // ✅ sent as query string
      },
    })
    alert('Profile updated successfully.')
    showEditModal.value = false
  } catch (err) {
    alert(err.response?.data?.message || err.message)
  }
}

const promptDelete = (user) => {
  userToDelete.value = user
  deleteError.value = ''
  showDeleteConfirm.value = true
}

const confirmDelete = async () => {
  if (!userToDelete.value) return;

  loading.value = true
  deleteError.value = ''

  try {
    // Use UID for deletion if available, otherwise use mail
    const identifier = userToDelete.value.uid
      ? { uid: userToDelete.value.uid }
      : { mail: userToDelete.value.mail }

    await axios.get(route('proxy.delete'), {
      params: {
        endpoint: 'user',
        ...identifier
      },
    })

    // Remove user from the list on the frontend for immediate feedback
    users.value = users.value.filter(u => u.uid !== userToDelete.value.uid)
    showDeleteConfirm.value = false
    alert('User deleted successfully.')

  } catch (err) {
    deleteError.value = err.response?.data?.message || 'Failed to delete user.'
  } finally {
    loading.value = false
    if (!deleteError.value) {
      userToDelete.value = null
    }
  }
}

const registerUser = async () => {
  registerResult.value = ''
  registerError.value = ''
  loading.value = true

  if (form.value.password !== form.value.confirmPassword) {
    registerError.value = 'Passwords do not match.'
    loading.value = false
    return
  }

  try {
    const auth = getAuth()
    const userCredential = await createUserWithEmailAndPassword(auth, form.value.email, form.value.password)
    const user = userCredential.user
    sessionStorage.setItem('searchedUserUid', user.uid)
    const idToken = await user.getIdToken()

    // Get device name (you can adjust `info` logic as needed)
    const info = {
      deviceName: navigator.userAgent
    }

    // Format current date
    const getFormattedDateTime = () => {
      const now = new Date()
      return now.toISOString()
    }

    await axios.post(
      route('proxy.post'),
      {
        call: '',
        created_date: getFormattedDateTime(),
        device_id: '',
        dob: '',
        edit_date: getFormattedDateTime(),
        img: '',
        isACActive: true,
        isAccountComplete: false,
        khua: '',
        lastLogin: getFormattedDateTime(),
        mail: user.email || '',
        name: form.value.name,
        uid: user.uid,
        veng: '',
        device_name: info.deviceName || '',
        token: idToken,
      },
      {
        params: {
          endpoint: 'register',
        },
      }
    )

    registerResult.value = 'User registered successfully.'
  } catch (err) {
    registerError.value = err.message || 'Registration failed.'
  } finally {
    loading.value = false
  }
}

const updateDOB = async () => {
  updateResult.value = ''
  updateError.value = ''
  loading.value = true

  try {
    const rawDate = new Date(newDob.value)
    const formattedDob = rawDate.toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    }) // "May 11, 1999"

    // ✅ Make sure you send `formattedDob`, not `newDob`
    const res = await axios.get(route('proxy.get'), {
      params: {
        endpoint: 'update-dob',
        uid: updateUid.value,
        dob: formattedDob,
      },
    })

    updateResult.value = 'DOB updated successfully.'
    console.log("Uid:", updateUid.value)
    console.log("dob:", newDob.value) 
  } catch (err) {
    updateError.value = err.response?.data?.message || err.message
    console.log("Uid:", updateUid.value)
    console.log("dob:", newDob.value) // 👈 still logs raw date
  } finally {
    loading.value = false
  }
}

const buttonClass = (tab) => {
  return `px-4 py-2 rounded-xl font-medium ${activeTab.value === tab
    ? 'bg-blue-600 text-white'
    : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
    }`
}

const insertUidFromCache = () => {
  const cachedUid = sessionStorage.getItem('searchedUserUid')
  if (cachedUid) {
    updateUid.value= cachedUid
    input.value= cachedUid
  } else {
    message.value = 'No cached UID found.'
    error.value = true
  }
}
</script>