<template>
    <div class="add-consum-form">
        <h2>Registre de nou consum</h2>
        <div>
            <button @click="platOingredient = 'plat'">Plat</button>
            <button @click="platOingredient = 'ingredient'">Ingredient</button>
        </div>
        <!-- Formulario para ingredientes -->
        <div class="ingredients" v-if="platOingredient === 'ingredient'">
            <!-- Alimentos -->
            <div>
                <label>Ingredient:</label>
                <input v-model="alimento" type="text" />

                <label>Quantitat (g):</label>
                <input v-model="cantidadAlimento" type="number" />

                <button @click="agregarAlimento">afegir</button>
            </div>

            <h3>afegit</h3>
            <ul>
                <li v-for="(item, index) in alimentos" :key="index">
                    {{ item.alimento }} - {{ item.cantidad }}g
                </li>
            </ul>

            <!-- Líquidos -->
            <div>
                <label>Beguda:</label>
                <select v-model="liquido">
                    <option value="agua">Agua</option>
                    <option value="otros">Otros</option>
                </select>

                <label>Quantitat (ml):</label>
                <input v-model="cantidadLiquido" type="number" />

                <button @click="agregarLiquido">afegir</button>
            </div>

            <h3>afegit</h3>
            <ul>
                <li v-for="(item, index) in liquidos" :key="index">
                    {{ item.liquido }} - {{ item.cantidad }}ml
                </li>
            </ul>
            <button><img src="../public/img/plus.svg" alt="" srcset="" @click="addConsumIngredient"></button>
        </div>
        <!-- Formulario para platos -->
        <div class="plats" v-if="platOingredient === 'plat'">
            <!-- Alimentos -->
            <div>
                <label>Plat:</label>
                <input v-model="alimento" type="text" />

                <label>Quantitat (g):</label>
                <input v-model="cantidadAlimento" type="number" />

                <button @click="agregarAlimento">afegir</button>
            </div>

            <h3>afegit</h3>
            <ul>
                <li v-for="(item, index) in alimentos" :key="index">
                    {{ item.alimento }} - {{ item.cantidad }}g
                </li>
            </ul>

            <!-- Líquidos -->
            <div>
                <label>Beguda:</label>
                <select v-model="liquido">
                    <option value="agua">Agua</option>
                    <option value="otros">Otros</option>
                </select>

                <label>Quantitat (ml):</label>
                <input v-model="cantidadLiquido" type="number" />

                <button @click="agregarLiquido">afegir</button>
            </div>

            <h3>afegit</h3>
            <ul>
                <li v-for="(item, index) in liquidos" :key="index">
                    {{ item.liquido }} - {{ item.cantidad }}ml
                </li>
            </ul>
            <button><img src="../public/img/plus.svg" alt="" srcset="" @click="addConsumPlat"></button>
        </div>
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
            platOingredient: 'ingredient',
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
        async addConsumIngredient() {
            const auth = useAuthStore()
            const router = useRouter()
            const translator = translator()
            const calorinator = calorinator()
            const repte_id = auth.repte.id;
            const consumedCalories = 0;

            const consum = {
                alimentos: this.alimentos,
                liquidos: this.liquidos,
            }
            if (this.platOingredient === 'plat') {
                //const translatedConsum = translator.translateTextEn(consum);
                //this.consumedCalories = calorinator.getCalories(consum, 'plat');
                console.log('En construccion');
            } else {
                //const translatedConsum = translator.translateTextEn(consum);
                this.alimentos.forEach(ingredient => {
                    this.consumedCalories = calorinator.getCalories(ingredient.alimento, ingredient.cantidad, 'ingredient');
                });
            }

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
                    auth.addConsumDia(response.consum.calories_consumides);
                    auth.setConsums(response.consum);
                }).catch((error) => {
                    console.error('Error:', error);
                });
            router.push('/mainView')
        },
        async addConsumPlat() {
            const auth = useAuthStore()
            const router = useRouter()
            const repte_id = auth.repte.id;

            const consum = {
                alimentos: this.alimentos,
                liquidos: this.liquidos,
            }
            const consumedCalories = calorinator.getDishNutritionData(consum);

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
                    auth.addConsumDia(response.consum.calories_consumides);
                    auth.setConsums(response.consum);
                }).catch((error) => {
                    console.error('Error:', error);
                });
            router.push('/mainView')
        },
    }
};
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

.add-consum-form {
    display: flex;
    flex-direction: column;
    max-width: 90vw;
    margin: 0 auto;
}
</style>