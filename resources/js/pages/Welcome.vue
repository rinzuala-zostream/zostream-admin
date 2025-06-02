<template>
    <div class="content">
      <img
        class="main-image"
        src="https://blr1.vultrobjects.com/zostream/AAPK/ssddff.jpg"
        alt="Girl in a jacket"
      />
      <h1>This Page is restricted!</h1>
      <p>Phalna neilo chuan admin.zostream.in hi hman theih a ni lo</p>
  
      <div class="link-container">
        <button class="login-button" @click="goToLogin">Login</button>
      </div>
    </div>
  </template>
  
  <script setup>
  const goToLogin = () => {
    // Replace with your actual login logic or router push
    window.location.href = "/login";
  };
  </script>
  
  <style scoped>
  body, html {
    margin: 0;
    padding: 0;
    font-family: 'DM Sans', sans-serif;
    background-color: #F4F5FF;
  }
  
  .content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100vw;
    height: 100vh;
    min-height: 675px;
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
  
  .link-container {
    margin-top: 32px;
  }
  
  .login-button {
    font-family: 'DM Sans', sans-serif;
    font-weight: 700;
    font-size: 14px;
    color: #fff;
    background-color: #673DE6;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .login-button:hover {
    background-color: #5631cc;
  }
  
  @media screen and (max-width: 580px) {
    h1, p, .link-container {
      width: 80%;
    }
  }
  </style>
  