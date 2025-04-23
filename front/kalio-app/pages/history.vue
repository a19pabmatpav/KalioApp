<template>
    <div class="history-page">
      <TimerBar @change-range="handleRangeChange" />
      <Chart :range="selectedRange" />
      <PdfMailer :range="selectedRange" />
    </div>
  </template>
  
  <script setup>
  definePageMeta({
  middleware: 'auth',
})
  
  const selectedRange = ref('month') // por defecto mes
  
  const handleRangeChange = (newRange) => {
    selectedRange.value = newRange
  }
  </script>
  
  <style scoped>
  .history-page {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    padding: 2rem;
  }
  </style>
  