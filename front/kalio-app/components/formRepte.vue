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
        <input type="number" id="maxCalories" v-model="maxCalories" required></input>
        </div>
      <button type="submit">Crear Repte</button>
    </form>
  </template>
  
  <script setup>  
  const startDate = ref(new Date().toISOString().slice(0, 16))
  const endDate = ref('')
  
  const submitRepte = async () => {
    const repteData = {
      start: startDate.value,
      end: endDate.value || null,
      maxCalories: maxCalories.value,
    }
  
    console.log('Datos del repte:', repteData)
    
    const response = await $fetch('http://localhost:8000/api/repte', {
      method: 'POST',
      body: JSON.stringify(repteData)
    })
      .then(response => response.json())
      .then(data => console.log(data))
      .catch(error => console.error('Error al crear el repte:', error))

    if (response.repte) {
      auth.setRepte(response.repte)
      localStorage.setItem('repte', response.repte)
      router.push('/mainView')
    } else {
      alert('Error al crear el repte')
    }
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
    border-radius: 5px;
    color: white;
    border: none;
    cursor: pointer;
    transition: background 0.3s;
  }
  
  button:hover {
    background-color: #e66a00;
  }
  </style>
  