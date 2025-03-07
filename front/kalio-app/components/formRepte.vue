<template>
    <form @submit.prevent="submitRepte">
      <div>
        <label for="start">Fecha de inicio:</label>
        <input type="datetime-local" id="start" v-model="startDate" disabled />
      </div>
  
      <div>
        <label for="end">Fecha de finalización (opcional):</label>
        <input type="datetime-local" id="end" v-model="endDate" />
      </div>
      
      <div>
        <label for="maxCalories">Límit diari de caloríes:</label>
        <textarea id="maxCalories" v-model="maxCalories" required></textarea>
        </div>
      <button type="submit">Crear Repte</button>
    </form>
  </template>
  
  <script setup>  
  // Fecha de inicio: Se establece al momento actual
  const startDate = ref(new Date().toISOString().slice(0, 16))
  // Fecha de finalización: Nula por defecto
  const endDate = ref('')
  
  const submitRepte = () => {
    const repteData = {
      start: startDate.value,
      end: endDate.value || null,
      maxCalories: maxCalories.value,
    }
  
    console.log('Datos del repte:', repteData)
    alert('Repte creado con éxito!')
  }
  </script>
  
  <style scoped>
  form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    background: #292F36;
    padding: 2rem;
    border-radius: 10px;
    color: white;
  }
  
  input {
    padding: 0.5rem;
    border-radius: 5px;
    border: 1px solid #ccc;
  }
  
  button {
    padding: 10px;
    background-color: #FF7A00;
    color: white;
    border: none;
    cursor: pointer;
    transition: background 0.3s;
  }
  
  button:hover {
    background-color: #e66a00;
  }
  </style>
  