<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const stats = ref({ total: 0, today: 0, yesterday: 0 });

onMounted(async () => {
  const res = await axios.get(route('count'));
  stats.value = res.data;
});
</script>

<template>
  <div>
    <p>Total Users: {{ stats.total }}</p>
    <p>New Today: {{ stats.today }}</p>
    <p>New Yesterday: {{ stats.yesterday }}</p>
  </div>
</template>
