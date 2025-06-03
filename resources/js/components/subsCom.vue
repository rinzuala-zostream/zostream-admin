<template>
    <div class="max-w-xl mx-auto p-6">
        <h1 class="text-2xl font-bold text-center mb-4">Subscription Manager</h1>

        <!-- Toggle Buttons -->
        <div class="flex gap-4 justify-center mb-6">
            <button @click="mode = 'add'" :class="[
                'px-4 py-2 rounded-xl font-medium',
                mode === 'add' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'
            ]">
                Add Subscription
            </button>
            <button @click="mode = 'get'" :class="[
                'px-4 py-2 rounded-xl font-medium',
                mode === 'get' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-800'
            ]">
                Get Subscription
            </button>
        </div>

        <!-- Divider Line -->
        <hr class="border-t border-gray-300 mb-6" />

        <!-- Add Subscription Form -->
        <div v-if="mode === 'add'">
            <!-- Plan Dropdown -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Select Plan</label>
                <select v-model="selectedPlan" @change="fetchPeriod"
                    class="w-full border px-4 py-2 rounded-lg shadow-sm">
                    <option disabled value="">-- Choose a plan --</option>
                    <option v-for="plan in plans" :key="plan" :value="plan">{{ plan }}</option>
                </select>
            </div>

            <!-- ID Input -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">User ID</label>
                <input v-model="form.id" type="text" class="w-full border px-4 py-2 rounded-lg shadow-sm"
                    placeholder="Enter user ID" />
            </div>

            <div class="flex justify-center mb-6">
                <button @click="insertUidFromCache"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-sm rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600">
                    Insert UID from Cache
                </button>
            </div>

            <!-- Device Type -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Device Type</label>
                <select v-model="form.device_type" class="w-full border px-4 py-2 rounded-lg shadow-sm">
                    <option disabled value="">-- Choose device --</option>
                    <option>Browser</option>
                    <option>Mobile</option>
                    <option>TV</option>
                </select>
            </div>

            <!-- Current Date (Optional) -->
            <div class="mb-6">
                <label class="block mb-1 font-medium">Current Date (optional)</label>
                <input v-model="form.currentDate" type="date" class="w-full border px-4 py-2 rounded-lg shadow-sm" />
            </div>

            <button @click="addSubscription" :disabled="!canSubmit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl">
                Submit Add Subscription
            </button>
            <div v-if="successMessage" class="text-center text-green-600 font-medium mt-4">
                {{ successMessage }}
            </div>

        </div>

        <!-- Get Subscription Form -->
        <div v-if="mode === 'get'">
            <!-- ID Input -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">User ID</label>
                <input v-model="form.id" type="text" class="w-full border px-4 py-2 rounded-lg shadow-sm"
                    placeholder="Enter user ID" />
            </div>

            <button @click="getSubscription" :disabled="!form.id"
                class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl">
                Fetch Subscription
            </button>
        </div>

        <!-- Status Messages -->
        <div v-if="loading" class="text-center text-gray-500 mt-6">Loading...</div>

        <!-- Subscription Response Cards -->
        <div v-if="Array.isArray(response)" class="mt-8 space-y-4">
            <div v-for="(item, index) in response" :key="index"
                class="border border-gray-300 dark:border-gray-700 rounded-xl p-4 shadow-sm bg-white dark:bg-gray-900">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        {{ item.device_type }}
                    </h3>
                    <span :class="[
                'text-sm px-3 py-1 rounded-full font-semibold',
                item.sub
                    ? 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200'
                    : 'bg-red-100 text-red-700 dark:bg-red-800 dark:text-red-200'
            ]">
                        {{ item.sub ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-2 text-sm text-gray-700 dark:text-gray-300">
                    <div><strong>Plan:</strong> {{ item.sub_plan }}</div>
                    <div><strong>Period:</strong> {{ item.period }} days</div>
                    <div><strong>Start Date:</strong> {{ item.create_date }}</div>
                    <div><strong>Expiry:</strong> {{ item.expiry_date }}</div>
                    <div><strong>Current:</strong> {{ item.current_date }}</div>
                    <div><strong>Device Support:</strong> {{ item.device_support }}</div>
                    <div><strong>Ads Free:</strong> {{ item.isAdsFree ? 'Yes' : 'No' }}</div>
                </div>
            </div>
        </div>

        <div v-if="error" class="text-center text-red-600 font-medium mt-4">{{ error }}</div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'

const mode = ref('add') // 'add' or 'get'

const plans = ['Kar 1', 'Thla 1', 'Thla 4', 'Thla 6', 'Kum 1']
const selectedPlan = ref('')

const form = ref({
    id: '',
    plan: '',
    device_type: '',
    period: '',
    currentDate: '',
})

const response = ref(null)
const error = ref('')
const loading = ref(false)
const successMessage = ref('')

const canSubmit = computed(() =>
    form.value.id && form.value.device_type && form.value.plan && form.value.period
)

const fetchPeriod = async () => {
    response.value = null
    error.value = ''
    form.value.plan = selectedPlan.value

    try {
        const res = await axios.get(route('proxy.get'), {
            params: {
                endpoint: 'price',
                plan: selectedPlan.value,
            },
        })
        form.value.period = res.data?.data.period || ''
        console.log(form.value.period)
    } catch (err) {
        error.value = err.response?.data?.message || 'Failed to fetch period.'
    }
}

const insertUidFromCache = () => {
    const cachedUid = sessionStorage.getItem('searchedUserUid')
    if (cachedUid) {
        form.value.id = cachedUid
        successMessage.value = 'UID inserted from cache.'
        error.value = ''
    } else {
        error.value = 'No cached UID found.'
        successMessage.value = ''
    }
}

const addSubscription = async () => {
    response.value = null
    error.value = ''
    successMessage.value = ''
    loading.value = true

    try {
        const res = await axios.get(route('proxy.get'), {
            params: {
                endpoint: 'add-subscription',
                plan: form.value.plan,
                id: form.value.id,
                device_type: form.value.device_type,
                period: form.value.period,
                currentDate: form.value.currentDate || null,
            },
        })
        response.value = res.data
        successMessage.value = res.data?.data?.message || 'Subscription added successfully.'
    } catch (err) {
        error.value = err.response?.data?.message || 'Failed to add subscription.'
    } finally {
        loading.value = false
    }
}

const getSubscription = async () => {
    response.value = null
    error.value = ''
    successMessage.value = ''
    loading.value = true

    try {
        const res = await axios.get(route('proxy.get'), {
            params: {
                endpoint: 'get-subscription',
                id: form.value.id,
            },
        })
        response.value = res.data
    } catch (err) {
        error.value = err.response?.data?.message || 'Failed to get subscription.'
    } finally {
        loading.value = false
    }
}
</script>
