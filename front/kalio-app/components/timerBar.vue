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
const selected = ref('day')

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

button.active {
  background-color: #ff2200;
  border: black solid 2px;
  color: white;
}

button {
  padding: 5px;
  background-color: #FF7A00;
  border-radius: 8px;
  color: white;
  border: black solid 1px;
  cursor: pointer;
  transition: background 0.3s;
  margin: 0 10px; /* Agrega margen horizontal entre los botones */
}
</style>
