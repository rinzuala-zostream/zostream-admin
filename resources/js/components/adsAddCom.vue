<template>
    <Teleport to="body">
        <transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="isVisible" class="fixed inset-0 z-50 bg-gray-900/80 backdrop-blur-sm" @click.self="$emit('close')">
                <div class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto p-4 pt-16 sm:pt-24">
                    <transition
                        enter-active-class="ease-out duration-300"
                        enter-from-class="opacity-0 scale-95"
                        enter-to-class="opacity-100 scale-100"
                        leave-active-class="ease-in duration-200"
                        leave-from-class="opacity-100 scale-100"
                        leave-to-class="opacity-0 scale-95"
                    >
                        <form
                            v-if="isVisible"
                            @submit.prevent="handleSubmit"
                            class="relative w-full max-w-4xl overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-700 dark:bg-gray-800"
                        >
                            <!-- Modal Header -->
                            <div
                                class="sticky top-0 z-10 flex items-center border-b border-gray-200 bg-white/95 p-6 backdrop-blur-sm dark:border-gray-700 dark:bg-gray-800/95"
                            >
                                <div
                                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-orange-100 to-orange-200 shadow-sm dark:from-orange-900/60 dark:to-orange-900/30"
                                >
                                    <svg
                                        class="h-6 w-6 text-orange-600 dark:text-orange-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M10.34 15.84c-.688 0-1.25-.562-1.25-1.25s.562-1.25 1.25-1.25 1.25.562 1.25 1.25-.562 1.25-1.25 1.25zM10.34 11.84c-.688 0-1.25-.562-1.25-1.25s.562-1.25 1.25-1.25 1.25.562 1.25 1.25-.562 1.25-1.25 1.25z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3.375 5.625c0-1.036.84-1.875 1.875-1.875h.375a3.75 3.75 0 013.75 3.75v1.5c0 .621.504 1.125 1.125 1.125h3.75c.621 0 1.125-.504 1.125-1.125v-1.5a3.75 3.75 0 013.75-3.75h.375c1.036 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875-1.875H5.25c-1.035 0-1.875-.84-1.875-1.875V5.625z"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-4 flex-grow">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Create New Advertisement</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Fill in the details for your new campaign</p>
                                </div>
                                <button
                                    @click="$emit('close')"
                                    type="button"
                                    class="rounded-full p-2 text-gray-400 transition-colors duration-200 hover:bg-gray-100 hover:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                >
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Modal Body (Scrollable) -->
                            <div class="max-h-[65vh] space-y-8 overflow-y-auto p-7">
                                <!-- General Information Section -->
                                <div class="space-y-6">
                                    <div class="flex items-center">
                                        <div class="mr-3 h-6 w-1.5 rounded-full bg-gradient-to-b from-orange-500 to-orange-600"></div>
                                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">General Information</h4>
                                    </div>
                                    <div>
                                        <label for="ad_name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                            >Ad Name <span class="text-red-500">*</span></label
                                        >
                                        <input
                                            v-model="formData.ads_name"
                                            id="ad_name"
                                            type="text"
                                            required
                                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-500 transition-colors duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400"
                                            placeholder="e.g., Summer Sale Promotion"
                                        />
                                    </div>
                                    <div>
                                        <label for="ad_description" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                            >Description</label
                                        >
                                        <textarea
                                            v-model="formData.description"
                                            id="ad_description"
                                            rows="4"
                                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-500 transition-colors duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400"
                                            placeholder="A detailed description of your advertisement..."
                                        ></textarea>
                                    </div>
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div>
                                            <label for="ad_period" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                                >Period (days) <span class="text-red-500">*</span></label
                                            >
                                            <input
                                                v-model.number="formData.period"
                                                id="ad_period"
                                                type="number"
                                                required
                                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-500 transition-colors duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400"
                                                placeholder="e.g., 7"
                                            />
                                        </div>
                                        <div>
                                            <label for="ad_type" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                                            <select
                                                v-model="formData.type"
                                                id="ad_type"
                                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 transition-colors duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                                            >
                                                <option value="website">Website</option>
                                                <option value="video">Video</option>
                                                <option value="image">Image Only</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Media Assets Section -->
                                <div class="space-y-6">
                                    <div class="flex items-center border-t border-gray-200 pt-6 dark:border-gray-700">
                                        <div class="mr-3 h-6 w-1.5 rounded-full bg-gradient-to-b from-orange-500 to-orange-600"></div>
                                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Media Assets</h4>
                                    </div>
                                    <div>
                                        <label for="ad_feature_img" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                            >Feature Image URL <span class="text-red-500">*</span></label
                                        >
                                        <input
                                            v-model="formData.feature_img"
                                            id="ad_feature_img"
                                            type="url"
                                            required
                                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-500 transition-colors duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400"
                                            placeholder="https://example.com/main-banner.jpg"
                                        />
                                        <div
                                            class="mt-4 flex aspect-video w-full max-w-md items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-gray-300 transition-colors duration-200 hover:border-gray-400 dark:border-gray-600 dark:hover:border-gray-500"
                                        >
                                            <img
                                                v-if="formData.feature_img"
                                                :src="formData.feature_img"
                                                @error="formData.feature_img = ''"
                                                alt="Feature preview"
                                                class="h-full w-full object-cover"
                                            />
                                            <div v-else class="py-8 text-center text-gray-400 dark:text-gray-500">
                                                <svg
                                                    class="mx-auto mb-3 h-12 w-12"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                                                    />
                                                </svg>
                                                <p class="text-sm">Image Preview</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="ad_video_url" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                            >Video URL</label
                                        >
                                        <input
                                            v-model="formData.video_url"
                                            id="ad_video_url"
                                            type="url"
                                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-500 transition-colors duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400"
                                            placeholder="https://example.com/promo-video.mpd"
                                        />
                                    </div>
                                </div>

                                <!-- Additional Images Section -->
                                <div class="space-y-6">
                                    <div class="flex items-center border-t border-gray-200 pt-6 dark:border-gray-700">
                                        <div class="mr-3 h-6 w-1.5 rounded-full bg-gradient-to-b from-orange-500 to-orange-600"></div>
                                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Additional Images (Up to 4)</h4>
                                    </div>
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div
                                            v-for="i in 4"
                                            :key="i"
                                            class="rounded-xl bg-gray-50 p-4 transition-colors duration-200 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700/70"
                                        >
                                            <label :for="`ad_img_${i}`" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                                >Image {{ i }} URL</label
                                            >
                                            <input
                                                v-model="formData[`img${i}`]"
                                                :id="`ad_img_${i}`"
                                                type="url"
                                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900 placeholder-gray-500 transition-colors duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400"
                                                placeholder="https://..."
                                            />
                                            <div
                                                class="mt-3 flex aspect-square w-full items-center justify-center overflow-hidden rounded-lg border-2 border-dashed border-gray-300 transition-colors duration-200 hover:border-gray-400 dark:border-gray-600 dark:hover:border-gray-500"
                                            >
                                                <img
                                                    v-if="formData[`img${i}`]"
                                                    :src="formData[`img${i}`]"
                                                    @error="formData[`img${i}`] = ''"
                                                    :alt="`Image ${i} preview`"
                                                    class="h-full w-full object-cover"
                                                />
                                                <div v-else class="py-6 text-center text-gray-400 dark:text-gray-500">
                                                    <svg
                                                        class="mx-auto mb-2 h-8 w-8"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                                                        />
                                                    </svg>
                                                    <p class="text-xs">Preview</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Error Message -->
                                <div
                                    v-if="submissionError"
                                    class="rounded-xl border border-red-200 bg-red-50 p-5 transition-all duration-300 dark:border-red-800 dark:bg-red-900/30"
                                >
                                    <p class="flex items-center text-sm font-medium text-red-700 dark:text-red-300">
                                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
                                            />
                                        </svg>
                                        {{ submissionError }}
                                    </p>
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div
                                class="flex flex-col items-center justify-between space-y-4 border-t border-gray-200 bg-gray-50 p-6 sm:flex-row sm:space-y-0 sm:space-x-3 dark:border-gray-700 dark:bg-gray-800/50"
                            >
                                <p class="text-sm text-gray-500 dark:text-gray-400"><span class="text-red-500">*</span> indicates required fields</p>
                                <div class="flex w-full space-x-3 sm:w-auto">
                                    <button
                                        @click="$emit('close')"
                                        type="button"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-medium text-gray-700 shadow-sm transition-colors duration-200 hover:bg-gray-50 focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:outline-none sm:w-auto dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-800"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        :disabled="isSubmitting"
                                        class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-3 text-sm font-medium text-white shadow-sm transition-all duration-200 hover:from-orange-600 hover:to-orange-700 focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:outline-none disabled:cursor-not-allowed disabled:opacity-70 sm:w-auto dark:focus:ring-offset-gray-800"
                                    >
                                        <svg
                                            v-if="isSubmitting"
                                            class="mr-2 -ml-1 h-4 w-4 animate-spin text-white"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                        >
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        <span>{{ isSubmitting ? 'Creating...' : 'Create Ad' }}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </transition>
                </div>
            </div>
        </transition>
    </Teleport>
</template>
<script setup>
import axios from 'axios';
import { ref, watch } from 'vue';
import { toast } from 'vue3-toastify';

const props = defineProps({
    isVisible: { type: Boolean, default: false },
});

const emit = defineEmits(['close', 'saved']);

const initialFormData = {
    ads_name: '',
    description: '',
    period: 7,
    type: 'website',
    feature_img: '',
    video_url: '',
    img1: '',
    img2: '',
    img3: '',
    img4: '',
};

const formData = ref({ ...initialFormData });
const isSubmitting = ref(false);
const submissionError = ref(null);

watch(
    () => props.isVisible,
    (newValue) => {
        if (newValue) {
            // Reset form every time the modal becomes visible
            formData.value = { ...initialFormData };
            submissionError.value = null;
        }
    },
);

const handleSubmit = async () => {
    isSubmitting.value = true;
    submissionError.value = null;

    const payload = { ...formData.value };
    Object.keys(payload).forEach((key) => {
        if (payload[key] === '' || payload[key] === null) {
            delete payload[key];
        }
    });

    try {
        const response = await axios.post(route('proxy.post'), payload, {
            params: { endpoint: 'ads' },
        });

        // Handle different possible success/error structures from the backend
        if (response.data?.status === true || response.data?.status === 'success') {
            toast.success(response.data.message || 'Advertisement created successfully!');
            emit('saved'); // Notify parent to close modal and refresh
        } else {
            const errorMsg = response.data?.error || response.data?.message || 'Failed to create advertisement.';
            submissionError.value = errorMsg;
            toast.error(errorMsg);
        }
    } catch (err) {
        const errorMessage = err.response?.data?.message || err.response?.data?.error || err.message || 'An unknown error occurred.';
        submissionError.value = errorMessage;
        toast.error(errorMessage);
    } finally {
        isSubmitting.value = false;
    }
};
</script>
