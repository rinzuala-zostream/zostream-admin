<template>
    <div class="min-h-screen bg-gray-50 p-6 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
        <div class="mx-auto max-w-3xl">
            <!-- HEADER -->
            <h1 class="mb-6 flex items-center gap-2 text-2xl font-bold">
                <span class="text-blue-500">📝</span>
                <span>Text Scroll Settings</span>
            </h1>

            <!-- CARD -->
            <div class="space-y-5 rounded-xl bg-white p-6 shadow dark:bg-gray-800">
                <!-- TEXT INPUT -->
                <div>
                    <label class="mb-1 block font-medium">Scroll Text</label>
                    <textarea
                        v-model="form.text"
                        rows="3"
                        placeholder="Enter scrolling text here..."
                        class="w-full rounded-lg border px-4 py-3 dark:bg-gray-700"
                    />
                </div>

                <!-- SHOW TOGGLE -->
                <div class="flex items-center justify-between">
                    <span class="font-medium">Show Text</span>

                    <label class="flex cursor-pointer items-center">
                        <div class="relative">
                            <input type="checkbox" class="sr-only" v-model="form.show" />
                            <div class="block h-6 w-12 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                            <div
                                class="dot absolute top-1 left-1 h-4 w-4 rounded-full bg-white transition"
                                :class="{ 'translate-x-6 bg-blue-500': form.show }"
                            ></div>
                        </div>
                    </label>
                </div>

                <!-- SAVE BUTTON -->
                <button @click="save" class="w-full rounded-lg bg-blue-500 py-3 font-semibold text-white hover:bg-blue-600">Save Settings</button>

                <!-- STATUS -->
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    Status:
                    <span :class="form.show ? 'text-green-500' : 'text-gray-400'">
                        {{ form.show ? 'Visible on app' : 'Hidden' }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref as dbRef, getDatabase, onValue, update } from 'firebase/database';
import { onMounted, ref } from 'vue';

const db = getDatabase();

const form = ref({
    text: '',
    show: false,
});

// 🔄 LOAD DATA (REALTIME)
const loadData = () => {
    const textRef = dbRef(db, 'text_scroll');

    onValue(textRef, (snapshot) => {
        const data = snapshot.val();

        if (data) {
            form.value = {
                text: data.text || '',
                show: data.show || false,
            };
        }
    });
};

// 💾 SAVE
const save = async () => {
    const textRef = dbRef(db, 'text_scroll');

    await update(textRef, {
        text: form.value.text,
        show: form.value.show,
    });

    alert('Text scroll updated successfully ✅');
};

onMounted(loadData);
</script>

<style>
.dot {
    transition: all 0.3s ease-in-out;
}
</style>
