<template>
    <div class="wrapper bg-[#F4F5FF] dark:bg-[#121212] text-[#1b1b18] dark:text-[#EDEDEC]">
      <!-- Content -->
      <div class="content">
        <img
          class="main-image"
          src="https://blr1.vultrobjects.com/zostream/AAPK/ssddff.jpg"
          alt="Restricted Access"
        />
        <h1 class="text-2xl font-bold mt-4">This Page is restricted!</h1>
        <p class="text-base text-[#727586] dark:text-[#aaa] max-w-[550px]">
          Phalna neilo chuan admin.zostream.in hi hman theih a ni lo
        </p>
  
        <!-- Auth Button -->
        <div class="mt-6">
          <Link
            v-if="$page.props.auth.user"
            :href="route('movie')"
            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal hover:border-[#1915014a] dark:border-[#3E3E3A] dark:hover:border-[#62605b]"
          >
            Dashboard
          </Link>
          <Link
            v-else
            :href="route('login')"
            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal hover:border-[#19140035] dark:hover:border-[#3E3E3A]"
          >
            Log in
          </Link>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3'
  </script>
  
  <style scoped>
  .wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    font-family: 'DM Sans', sans-serif;
  }
  
  .content {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 1rem;
  }
  
  .main-image {
    width: 100%;
    max-width: 650px;
    height: auto;
  }
  
  @media screen and (max-width: 580px) {
    .content {
      width: 80%;
      margin: auto;
    }
  }
  </style>
  