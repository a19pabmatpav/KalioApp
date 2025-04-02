<template>
    <form @submit.prevent="submitRepte">
      <div>
        <label for="start">Fecha de inicio:</label>
        <input type="datetime-local" id="start" v-model="startDate" />
      </div>
  
      <div>
        <label for="end">Fecha de finalización (opcional):</label>
        <input type="datetime-local" id="end" v-model="endDate" />
      </div>
      
      <div>
        <label for="maxCalories">Límit diari de caloríes:</label>
        <input type="number" id="maxCalories" v-model="maxCalories" required/>
        </div>
      <button type="submit">Crear Repte</button>
    </form>
  </template>
  
  <script setup>  
  const startDate = ref('')
  const endDate = ref('')
  const authStore = useAuthStore()
  const maxCalories = ref('')
  const router = useRouter()

  const submitRepte = async () => {
    const repteData = {
      nom: `Repte de ${authStore.username}`,
      data_inici: startDate.value,
      data_fi: endDate.value || null,
      limit_calories_diari: maxCalories.value,
    }
  
    console.log('Datos del repte:', repteData)
    
    const response = await $fetch('http://kalioapi.a19pabmatpav.daw.inspedralbes.cat/public/api/reptes', {
      method: 'POST',
      body: JSON.stringify(repteData),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${localStorage.getItem('authToken')}`
      }
    })
      
      .then(data => {
        console.log(data)
        authStore.setRepte(data.repte)
        localStorage.setItem('repte', data.repte)
        router.push('/mainView')
      })
      .catch(error => console.error('Error al crear el repte:', error))
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
  