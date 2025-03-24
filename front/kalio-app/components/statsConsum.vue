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
  
  // Funciones
  function getConsumData() {
    // TODO: Lógica para obtener datos reales
  }
  
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
  const createPolarAreaChart = (canvasId) => {
    const ctx = document.getElementById(canvasId).getContext('2d');
    return new Chart(ctx, {
      type: 'polarArea',
      data: {
        labels: ['Calories', 'Proteïnes', 'Sucres', 'Aigua'],
        datasets: [
          {
            data: [0, 0, 0, 0],
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
  
  // Montar los gráficos al cargar el componente
  onMounted(() => {
    caloriesChart.value = createBarChart('caloriesChart', 0, 'Calories');
    proteinChart.value = createBarChart('proteinChart', 0, 'Proteïnes');
    sugarChart.value = createBarChart('sugarChart', 0, 'Sucres');
    waterChart.value = createBarChart('waterChart', 0, 'Aigua');
  
    statsChartComplet.value = createPolarAreaChart('statsChartComplet');
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
    display: flex;
  }

    h1 {
        color: black;
        font-size: 24px;
        margin-bottom: 20px;
        height: 70px;
        width: 100%;
    }
  
  .grafic {
    position: relative;
    max-height: 200px;
    max-width: 40px;
    margin-top: 150px;
    margin-bottom: 20px;
    margin-right: 5px;
    padding: 10px;
    gap: 5px;
    background-color: #2D1B52;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  
  canvas {
    width: 100%;
    height: 300px;
  }
  
  .moreStats {
    margin-top: 30px;
  }
  
  .graficComplet {
    position: relative;
    padding: 20px;
    background-color: #2D1B52;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  </style>
  