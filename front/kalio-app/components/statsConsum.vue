<template>
  <button><img src="../public/img/plus.svg" alt="" srcset="" @click="addConsum"></button>
  <div class="stats-consum">
    <h1>Estadístiques de Consum:</h1>

    <div class="grafic">
      <canvas id="caloriesChart" ref="caloriesChart"></canvas>
    </div>
    <div class="grafic">
      <canvas id="proteinChart" ref="proteinChart"></canvas>
    </div>
    <div class="grafic">
      <canvas id="sugarChart" ref="sugarChart"></canvas>
    </div>
    <div class="grafic">
      <canvas id="waterChart" ref="waterChart"></canvas>
    </div>
    <img src="../public/img/info-circle.svg" alt="infoBtn" @click="showInfo" />
    <div class="moreStats">
      <div class="graficComplet">
        <canvas id="statsChartComplet"></canvas>
      </div>
    </div>
  </div>
</template>

<script setup>
// Importar Chart de Chart.js
import { Chart } from 'chart.js/auto'; // Importación del gráfico
import { onMounted, onBeforeUnmount, ref } from 'vue'; // Importar los hooks de Vue
const piniaStore = useAuthStore(); // Acceder al store de autenticación (Pinia)
const repteId = piniaStore.repte.id; // Obtener el id del reto desde el store
const maxCalories = piniaStore.repte.limit_calories_diari; // Obtener el límite de calorías desde el store
const maxProteins = (maxCalories * 0.15) / 4; // Obtener el límite de proteínas desde el store
const maxSugars = (maxCalories * 0.10) / 4; // Obtener el límite de azúcares desde el store
const maxWater = 2500; // Obtener el límite de agua desde el store

// Referencias para cada gráfico (se usarán en los hooks de Vue)
const caloriesChart = ref(null);
const proteinChart = ref(null);
const sugarChart = ref(null);
const waterChart = ref(null);
const statsChartComplet = ref(null);

// Datos máximos para calcular porcentajes
const maxStats = {
  calories: maxCalories,  // Calorías máximas (usadas para los porcentajes)
  proteins: maxProteins,    // Proteínas máximas
  sugars: maxSugars,      // Azúcares máximos
  water: maxWater,       // Agua máxima
};

console.log('maxStats', maxStats);

// Datos de consumo diarios
const dades = ref({
  dailyStats: {
    calories: 0, // Calorías consumidas
    proteins: 0, // Proteínas consumidas
    sugars: 0,   // Azúcares consumidos
    water: 0,    // Agua consumida
  },
  percentStats: {
    calories: 0,   // Porcentaje de calorías
    proteins: 0,   // Porcentaje de proteínas
    sugars: 0,     // Porcentaje de azúcares
    water: 0,      // Porcentaje de agua
  },
});

// Crear un gráfico de barras
const createBarChart = (canvasId, data, label) => {
  // Obtener el contexto del lienzo (canvas)
  const ctx = document.getElementById(canvasId)?.getContext('2d');
  if (!ctx) return;

  // Crear el gráfico con Chart.js
  return new Chart(ctx, {
    type: 'bar', // Tipo de gráfico
    data: {
      labels: ['Avui'], // Etiqueta en el eje X
      datasets: [
        {
          label: label,   // Etiqueta del dataset
          data: [data],    // Los datos dinámicos del gráfico
          backgroundColor: '#4ECDC4', // Color de fondo de las barras
          borderWidth: 2,  // Grosor del borde
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: { display: true },   // Mostrar el eje X
        y: { beginAtZero: true, max: 100 }, // Mostrar el eje Y desde 0 hasta 100
      },
      plugins: {
        legend: {
          display: true,  // Mostrar la leyenda
        },
      },
    },
  });
};

// Crear gráfico de área polar
const createPolarAreaChart = (canvasId, data) => {
  // Obtener el contexto del lienzo (canvas)
  const ctx = document.getElementById(canvasId)?.getContext('2d');
  if (!ctx) return;

  // Crear el gráfico con Chart.js
  return new Chart(ctx, {
    type: 'polarArea', // Tipo de gráfico
    data: {
      labels: ['Calories', 'Proteïnes', 'Sucres', 'Aigua'],  // Etiquetas para las áreas
      datasets: [
        {
          data: [data.calories, data.proteins, data.sugars, data.water], // Datos a graficar
          backgroundColor: ['#4ECDC4', '#F7FFF7', '#FF6B6B', '#1D3557'], // Colores de las áreas
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } }, // Desactivar la leyenda
    },
  });
};

// Obtener datos de consumo de la API
const getConsumData = async () => {
  const token = piniaStore.token; // Obtener el token de autenticación
  console.log('token', token);
  
  console.log('maxStats', maxStats);
  console.log('buscando datos...');


  try {
    // Solicitar datos de consumo al servidor
    const response = await fetch(`http://localhost:8000/api/consums/${repteId}`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token.value}`, // Usar el token de autenticación
      },
    });

    if (response.status === 404) {
      // Si no se encuentran datos, inicializar con ceros
      dades.value.dailyStats = {
        calories: 0,
        proteins: 0,
        sugars: 0,
        water: 0,
      };
      dades.value.percentStats = {
        calories: 0,
        proteins: 0,
        sugars: 0,
        water: 0,
      };
      console.log("No s'han trobat consums per a aquest repte avui.");
      return;
    } else {
      // Si hay datos, procesarlos y actualizar los valores
      const data = await response.json();
      console.log(data);

      // Sumar las calorías consumidas
      const totalCalories = data.reduce((sum, item) => sum + item.calories_consumides, 0);
      const totalProteins = data.reduce((sum, item) => sum + item.proteines_consumides, 0);
      const totalSugars = data.reduce((sum, item) => sum + item.sucres_consumits, 0);
      const totalWater = data.reduce((sum, item) => sum + item.aigua_consumida, 0);

      // Actualizar los valores de consumo diario
      dades.value.dailyStats = {
        calories: totalCalories, // Total de calorías consumidas
        proteins: totalProteins, // Ajustar si tienes datos de proteínas
        sugars: totalSugars,   // Ajustar si tienes datos de azúcares
        water: totalWater,    // Ajustar si tienes datos de agua
      };

      // Calcular los porcentajes
      dades.value.percentStats = {
        calories: (totalCalories / maxStats.calories) * 100,
        proteins: (totalProteins / maxStats.proteins) * 100, // Ajustar si tienes datos de proteínas
        sugars: (totalSugars / maxStats.sugars) * 100,   // Ajustar si tienes datos de azúcares
        water: (totalWater / maxStats.water) * 100,    // Ajustar si tienes datos de agua
      };

      console.log('Dades actualitzades:', dades.value);
      return { status: 'success' };
    };
  } catch (error) {
    console.error("Error al obtener datos:", error);
  }
};

// Mostrar información en un alert
const showInfo = () => {
  alert(`Aquí pots veure com ha estat el teu consum d'avui.
Tens 4 gràfics que mostren el percentatge de calories, proteïnes, sucres i aigua que has consumit.
Al final, trobaràs un gràfic complet que reuneix totes aquestes dades per ajudar-te a entendre millor el teu consum total.`);
};

// Montar los gráficos cuando se monta el componente
onMounted(async () => {
  await getConsumData(); // Esperar la respuesta de la API

  // Crear los gráficos después de obtener los datos
  caloriesChart.value = createBarChart('caloriesChart', dades.value.percentStats.calories, 'Calories');
  proteinChart.value = createBarChart('proteinChart', dades.value.percentStats.proteins, 'Proteïnes');
  sugarChart.value = createBarChart('sugarChart', dades.value.percentStats.sugars, 'Sucres');
  waterChart.value = createBarChart('waterChart', dades.value.percentStats.water, 'Aigua');

  // Crear el gráfico completo
  statsChartComplet.value = createPolarAreaChart('statsChartComplet', dades.value.percentStats);
});

// Desmontar los gráficos cuando se desmonta el componente
onBeforeUnmount(() => {
  caloriesChart.value?.destroy();
  proteinChart.value?.destroy();
  sugarChart.value?.destroy();
  waterChart.value?.destroy();
  statsChartComplet.value?.destroy();
});

// Navegar a la pantalla de agregar consumo
const addConsum = () => {
  const router = useRouter();
  router.push('/addConsum');
};
</script>



<style scoped>
.stats-consum {
  padding: 20px;
  background-color: #8A2BE2;
  display: grid;
  grid-template-rows: auto 1fr auto;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}

h1 {
  color: black;
  font-size: 24px;
  margin-bottom: 20px;
  grid-column: 1 / -1;
  text-align: center;
  height: 70px;
  width: 100%;
}

.grafic {
  position: relative;
  height: 200px;
  max-width: 100%;
  background-color: #2D1B52;
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 10px;
}

canvas {
  width: 100%;
  height: 100%;
}

img {

  position: absolute;
  right: 25px;
}
button {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #FF7A00;
    margin-top: 2vh;
    margin-left: 15vw;
}

button img {
    width: 30px;
    height: 30px;
}

.moreStats {
  grid-column: 1 / -1;
  margin-top: 20px;
  display: flex;
  justify-content: center;
}

.graficComplet {
  height: 200px;
  width: 165px;
  position: relative;
  padding: 20px;
  background-color: #2D1B52;
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>
