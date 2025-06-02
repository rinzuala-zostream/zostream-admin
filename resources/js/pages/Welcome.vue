<template>
    <div class="wrapper">
      <nav class="flex items-center justify-end gap-4 nav-bar">
        <Link
          v-if="$page.props.auth.user"
          :href="route('movie')"
          class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
        >
          Dashboard
        </Link>
        <template v-else>
          <Link
            :href="route('login')"
            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
          >
            Log in
          </Link>
        </template>
      </nav>
  
      <div class="content">
        <img
          class="main-image"
          src="https://blr1.vultrobjects.com/zostream/AAPK/ssddff.jpg"
          alt="Girl in a jacket"
        />
        <h1>This Page is restricted!</h1>
        <p>Phalna neilo chuan api.zostream.in hi hman theih a ni lo</p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { Link, usePage } from '@inertiajs/vue3'
  </script>
  
  <style scoped>
  .wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background-color: #F4F5FF;
    font-family: 'DM Sans', sans-serif;
  }
  
  .nav-bar {
    padding: 1rem;
  }
  
  .content {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
  }
  
  h1 {
    font-size: 24px;
    font-weight: 700;
    margin: 8px;
  }
  
  p {
    font-size: 16px;
    font-weight: 400;
    color: #727586;
    max-width: 550px;
    margin: 0;
  }
  
  .main-image {
    width: 100%;
    max-width: 650px;
    height: auto;
  }
  
  @media screen and (max-width: 580px) {
    h1,
    p,
    .nav-bar {
      width: 80%;
      margin: auto;
    }
  }
  </style>
  