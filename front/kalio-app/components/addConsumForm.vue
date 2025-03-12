<template>
    <div>
        <h2>Registro de alimentos y líquidos</h2>

        <!-- Alimentos -->
        <div>
            <label>Alimento:</label>
            <input v-model="alimento" type="text" />

            <label>Cantidad (g):</label>
            <input v-model="cantidadAlimento" type="number" />

            <button @click="agregarAlimento">add</button>
        </div>

        <h3>added</h3>
        <ul>
            <li v-for="(item, index) in alimentos" :key="index">
                {{ item.alimento }} - {{ item.cantidad }}g
            </li>
        </ul>

        <!-- Líquidos -->
        <div>
            <label>Líquido:</label>
            <select v-model="liquido">
                <option value="agua">Agua</option>
                <option value="otros">Otros</option>
            </select>

            <label>Cantidad (ml):</label>
            <input v-model="cantidadLiquido" type="number" />

            <button @click="agregarLiquido">add</button>
        </div>

        <h3>addedd</h3>
        <ul>
            <li v-for="(item, index) in liquidos" :key="index">
                {{ item.liquido }} - {{ item.cantidad }}ml
            </li>
        </ul>
        <button><img src="../public/img/plus.svg" alt="" srcset="" @click="addConsum"></button>
    </div>
</template>

<script>
export default {
    name: 'AddConsumForm',
    data() {
        return {
            alimento: '',
            cantidadAlimento: 0,
            alimentos: [],
            liquido: 'agua',
            cantidadLiquido: 0,
            liquidos: [],
        };
    },
    methods: {
        agregarAlimento() {
            this.alimentos.push({
                alimento: this.alimento,
                cantidad: this.cantidadAlimento,
            });
        },
        agregarLiquido() {
            this.liquidos.push({
                liquido: this.liquido,
                cantidad: this.cantidadLiquido,
            });
        },
        // Función para calcular las calorías consumida. Proximamente se hará con la API exterior.
        calorinator(consum) {
                let totalCalories = 0;
                consum.alimentos.forEach((alimento) => {
                    totalCalories += alimento.cantidad;
                });
                consum.liquidos.forEach((liquido) => {
                    totalCalories += liquido.cantidad;
                });
                return totalCalories;
            },
        async addConsum() {
            const auth = useAuthStore()
            const repte_id = auth.repte.id;

            const consum = {
                alimentos: this.alimentos,
                liquidos: this.liquidos,
            }
            const consumedCalories = this.calorinator(consum);

            const response = await $fetch('http://localhost:8000/api/addConsum', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Bearer': localStorage.getItem('authToken'),
                },
                body: JSON.stringify({
                    repte_id: repte_id,
                    calories: consumedCalories,
                    data: new Date().toISOString().split('T')[0]
                }),
            })
            .then((response) => {
                console.log('Success:', response);
                auth.addConsumDia(response.calories);
                this.$router.push('/mainView');
            }).catch((error) => {
                console.error('Error:', error);
            });
        },
}};
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