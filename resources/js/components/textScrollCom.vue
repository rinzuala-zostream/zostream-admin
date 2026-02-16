<template>
    <div class="min-h-screen bg-gray-50 p-6 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
        <div class="mx-auto max-w-4xl">
            <!-- HEADER -->
            <h1 class="mb-6 flex items-center gap-2 text-2xl font-bold">
                <span class="text-blue-500">📝</span>
                <span>Text Scroll Manager</span>
            </h1>

            <!-- CREATE FORM -->
            <div class="mb-8 rounded-xl bg-white p-6 shadow dark:bg-gray-800">
                <h2 class="mb-4 text-lg font-semibold">Add New Text</h2>

                <form @submit.prevent="addText" class="space-y-4">
                    <input
                        v-model="newText.text"
                        type="text"
                        placeholder="Enter scrolling text..."
                        class="w-full rounded-lg border px-4 py-3 dark:bg-gray-700"
                        required
                    />

                    <label class="flex items-center gap-2">
                        <input type="checkbox" v-model="newText.show" />
                        <span>Show</span>
                    </label>

                    <button class="rounded-lg bg-blue-500 px-5 py-2 text-white hover:bg-blue-600">Add Text</button>
                </form>
            </div>

            <!-- LIST -->
            <div class="space-y-4">
                <div
                    v-for="item in texts"
                    :key="item.id"
                    class="flex items-start justify-between gap-4 rounded-xl bg-white p-5 shadow dark:bg-gray-800"
                >
                    <div class="flex-1 space-y-2">
                        <!-- VIEW MODE -->
                        <div v-if="editingId !== item.id">
                            <p class="font-medium">{{ item.text }}</p>
                            <p class="text-sm" :class="item.show ? 'text-green-500' : 'text-gray-400'">
                                {{ item.show ? 'Visible' : 'Hidden' }}
                            </p>
                        </div>

                        <!-- EDIT MODE -->
                        <div v-else class="space-y-2">
                            <input v-model="editCache.text" class="w-full rounded border px-3 py-2 dark:bg-gray-700" />
                            <label class="flex items-center gap-2">
                                <input type="checkbox" v-model="editCache.show" />
                                <span>Show</span>
                            </label>

                            <div class="mt-2 flex gap-2">
                                <button @click="saveEdit(item.id)" class="rounded bg-blue-500 px-3 py-1 text-white">Save</button>
                                <button @click="cancelEdit" class="rounded bg-gray-400 px-3 py-1">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <!-- ACTIONS -->
                    <div class="flex flex-col gap-2">
                        <!-- TOGGLE SHOW -->
                        <button @click="toggleShow(item)" class="rounded bg-gray-200 px-3 py-1 text-sm dark:bg-gray-700">
                            {{ item.show ? 'Hide' : 'Show' }}
                        </button>

                        <!-- EDIT -->
                        <button @click="startEdit(item)" class="text-sm text-blue-500">Edit</button>

                        <!-- DELETE -->
                        <button @click="deleteText(item.id)" class="text-sm text-red-500">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref as dbRef, getDatabase, onValue, push, remove, update } from 'firebase/database';
import { onMounted, ref } from 'vue';

const db = getDatabase();

const texts = ref([]);
const newText = ref({ text: '', show: true });

// edit state
const editingId = ref(null);
const editCache = ref({ text: '', show: false });

// 🔄 FETCH DATA (Realtime)
const fetchTexts = () => {
    const textRef = dbRef(db, 'text_scroll');

    onValue(textRef, (snapshot) => {
        const data = snapshot.val();
        const result = [];

        for (let id in data) {
            result.push({
                id,
                ...data[id],
            });
        }

        texts.value = result.reverse();
    });
};

// ➕ ADD
const addText = async () => {
    const textRef = dbRef(db, 'text_scroll');

    await push(textRef, {
        text: newText.value.text,
        show: newText.value.show,
    });

    newText.value = { text: '', show: true };
};

// ✏️ START EDIT
const startEdit = (item) => {
    editingId.value = item.id;
    editCache.value = { text: item.text, show: item.show };
};

// ❌ CANCEL EDIT
const cancelEdit = () => {
    editingId.value = null;
};

// 💾 SAVE EDIT
const saveEdit = async (id) => {
    const itemRef = dbRef(db, `text_scroll/${id}`);

    await update(itemRef, {
        text: editCache.value.text,
        show: editCache.value.show,
    });

    editingId.value = null;
};

// 🔄 TOGGLE SHOW
const toggleShow = async (item) => {
    const itemRef = dbRef(db, `text_scroll/${item.id}`);

    await update(itemRef, {
        show: !item.show,
    });
};

// 🗑 DELETE
const deleteText = async (id) => {
    if (!confirm('Delete this text?')) return;

    const itemRef = dbRef(db, `text_scroll/${id}`);
    await remove(itemRef);
};

onMounted(fetchTexts);
</script>
