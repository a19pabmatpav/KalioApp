<template>
  <div class="history-page">
    <TimerBar @change-range="handleRangeChange" />
    <div ref="chartRef">
      <Chart :range="selectedRange" />
    </div>
    <PdfMailer :range="selectedRange" :chart-element="chartRef"/>
  </div>
</template>

<script setup>
definePageMeta({
  middleware: 'auth',
})

const selectedRange = ref('month') // por defecto mes
const chartRef = ref(null)

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