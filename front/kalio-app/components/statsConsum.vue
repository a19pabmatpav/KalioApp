<template>
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
import { Chart } from 'chart.js/auto';
import { onMounted, onBeforeUnmount, ref } from 'vue';
const piniaStore = useAuthStore(); // Reemplaza con el nombre real de tu store
const repteId = piniaStore.repte.id; // Accede al repte_id desde el estado
const maxCalories = piniaStore.repte.limit_calories_diari; // Accede al límite de calorías desde el estado
console.log(maxCalories);

// Referencias para cada gráfico
const caloriesChart = ref(null);
const proteinChart = ref(null);
const sugarChart = ref(null);
const waterChart = ref(null);
const statsChartComplet = ref(null);

// Datos máximos para calcular porcentajes
const maxStats = {
  calories: maxCalories,
  proteins: ref(null),
  sugars: ref(null),
  water: ref(null),
};

// Datos de consumo diarios
const dades = ref({
  dailyStats: {
    calories: 0,
    proteins: 0,
    sugars: 0,
    water: 0,
  },
  percentStats: {
    calories: 30,
    proteins: 50,
    sugars: 40,
    water: 80,
  },
});

// Crear un gráfico de barras
const createBarChart = (canvasId, data, label) => {
  const ctx = document.getElementById(canvasId)?.getContext('2d');
  if (!ctx) return;

  return new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Avui'], // Etiqueta para el eje X
      datasets: [
        {
          label: label, // Etiqueta del dataset
          data: [data], // Pasar el valor dinámico como un array
          backgroundColor: '#4ECDC4',
          borderWidth: 2,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          display: true, // Mostrar el eje X
        },
        y: {
          beginAtZero: true, // Asegurarse de que el eje Y comience en 0
          max: 100, // Establecer el valor máximo en 100 para trabajar con porcentajes
        },
      },
      plugins: {
        legend: {
          display: true, // Mostrar la leyenda
        },
      },
    },
  });
};

// Crear gráfico polar area
const createPolarAreaChart = (canvasId, data) => {
  const ctx = document.getElementById(canvasId)?.getContext('2d');
  if (!ctx) return;
  return new Chart(ctx, {
    type: 'polarArea',
    data: {
      labels: ['Calories', 'Proteïnes', 'Sucres', 'Aigua'],
      datasets: [
        {
          data: [data.calories, data.proteins, data.sugars, data.water],
          backgroundColor: ['#4ECDC4', '#F7FFF7', '#FF6B6B', '#1D3557'],
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
    },
  });
};

// Obtener datos de consumo
const getConsumData = async () => {
  console.log('maxStats', maxStats);
  console.log('buscando datos...');

  try {
    const response = await fetch(`http://kalioapi.a19pabmatpav.daw.inspedralbes.cat/public/api/consums/${repteId}`, {
      method: 'GET',
      headers: { 'Content-Type': 'application/json' },
      authorization: `Bearer ${localStorage.getItem('token')}`,
    });
    if (response.status === 404) {
      // Si no hay datos, inicializar con ceros
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
      const data = await response.json();
      console.log(data);
      console.log(data.calories);
      
      // Actualizar datos
      dades.value.dailyStats = {
        calories: data.calories,
        proteins: data.proteins,
        sugars: data.sugars,
        water: data.water,
      }
      dades.value.percentStats = {
        calories: (data.calories / maxStats.calories) * 100,
         proteins: (data.proteins / maxStats.proteins) * 100,
         sugars: (data.sugars / maxStats.sugars) * 100,
         water: (data.water / maxStats.water) * 100,
      }
      console.log('Dades actualitzades:', dades.value);

      return { status: 'success'};
    };
  } catch (error) {
    console.error("Error al obtener datos:", error);
  }
};

// Mostrar información
const showInfo = () => {
  alert(`Aquí pots veure com ha estat el teu consum d'avui.
Tens 4 gràfics que mostren el percentatge de calories, proteïnes, sucres i aigua que has consumit.
Al final, trobaràs un gràfic complet que reuneix totes aquestes dades per ajudar-te a entendre millor el teu consum total.`);
};

// Montar los gráficos al cargar el componente
onMounted(async () => {
  await getConsumData(); // Esperar a obtener los datos

  // Crear los gráficos
  caloriesChart.value = createBarChart('caloriesChart', dades.value.percentStats.calories, 'Calories');
  proteinChart.value = createBarChart('proteinChart', dades.value.percentStats.proteins, 'Proteïnes');
  sugarChart.value = createBarChart('sugarChart', dades.value.percentStats.sugars, 'Sucres');
  waterChart.value = createBarChart('waterChart', dades.value.percentStats.water, 'Aigua');

  // Gráfico completo
  statsChartComplet.value = createPolarAreaChart('statsChartComplet', dades.value.percentStats);
});

// Destruir los gráficos al desmontar el componente
onBeforeUnmount(() => {
  caloriesChart.value?.destroy();
  proteinChart.value?.destroy();
  sugarChart.value?.destroy();
  waterChart.value?.destroy();
  statsChartComplet.value?.destroy();
});
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
