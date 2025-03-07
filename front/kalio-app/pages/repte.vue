<template>
    <div class="repte-page">
      <h1>Repte</h1>
      <formRepte />
    </div>
  </template>
  
  <script setup>
    definePageMeta({
  middleware: 'auth'
})
  </script>
  
  <style scoped>
  .repte-page {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 75vh;
    padding: 20px;
  }
  </style>
  