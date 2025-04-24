<template>
    <div class="timer-bar">
      <button
        v-for="option in options"
        :key="option"
        @click="selectRange(option)"
        :class="{ active: option === selected }"
      >
        {{ option }}
      </button>
    </div>
  </template>
  
  <script setup>
  const emit = defineEmits(['change-range'])
  
  const options = ['year', 'month', 'week', 'day']
  const selected = ref('month')
  
  const selectRange = (range) => {
    selected.value = range
    emit('change-range', range)
  }
  </script>
  
  <style scoped>
  .timer-bar {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  button {
    padding: 0.5rem 1rem;
    cursor: pointer;
  }
  button.active {
    background-color: #4ECDC4;
    color: white;
  }
  </style>
  