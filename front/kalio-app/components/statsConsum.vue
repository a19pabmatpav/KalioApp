<template>
  <div class="stats-consum">
    <h1>Estadístiques de Consum:</h1>

    <div class="grafic">
      <canvas id="caloriesChart"></canvas>
    </div>
    <div class="grafic">
      <canvas id="proteinChart"></canvas>
    </div>
    <div class="grafic">
      <canvas id="sugarChart"></canvas>
    </div>
    <div class="grafic">
      <canvas id="waterChart"></canvas>
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

// Referencias para cada gráfico
const caloriesChart = ref(null);
const proteinChart = ref(null);
const sugarChart = ref(null);
const waterChart = ref(null);
const statsChartComplet = ref(null);

// Crear un gráfico de barras
const createBarChart = (canvasId, data, label) => {
  const ctx = document.getElementById(canvasId).getContext('2d');
  return new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Avui'],
      datasets: [
        {
          label: label,
          data: [data],
          backgroundColor: '#4ECDC4',
          borderColor: '#292F36',
          borderWidth: 2,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          display: false,
        },
        y: {
          display: false,
        },
      },
      plugins: {
        legend: {
          display: false,
        },
      },
    },
  });
};

// Crear gráfico polar area
const createPolarAreaChart = (canvasId, data) => {
  const ctx = document.getElementById(canvasId).getContext('2d');
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
      plugins: {
        legend: {
          display: false,
        },
      },
    },
  });
};

function getConsumData() {
  return {
    // Datos de consumo diario de ejemplo
    dailyStats: {
      calories: 2000,
      proteins: 155,
      sugars: 80,
      water: 1500
    },// Datos de consumo máximo
    maxStats: {
      calories: 3000,
      proteins: 200,
      sugars: 100,
      water: 3000
    },
    percentStats: {
      calories: 2000 / 3000 * 100,
      proteins: 155 / 200 * 100,
      sugars: 80 / 100 * 100,
      water: 1500 / 3000 * 100
    }
  };
}

const showInfo = () => {
  alert("Aquí pots veure com ha estat el teu consum d'avui.\nTens 4 gràfics que mostren el percentatge de calories, proteïnes, sucres i aigua que has consumit.\nAl final, trobaràs un gràfic complet que reuneix totes aquestes dades per ajudar-te a entendre millor el teu consum total.");

};

// Montar los gráficos al cargar el componente
onMounted(() => {
  const data = getConsumData();
  caloriesChart.value = createBarChart('caloriesChart', data.percentStats.calories, 'Calories');
  proteinChart.value = createBarChart('proteinChart', data.percentStats.proteins, 'Proteïnes');
  sugarChart.value = createBarChart('sugarChart', data.percentStats.sugars, 'Sucres');
  waterChart.value = createBarChart('waterChart', data.percentStats.water, 'Aigua');

  statsChartComplet.value = createPolarAreaChart('statsChartComplet', data.percentStats);
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
