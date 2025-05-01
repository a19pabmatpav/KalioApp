<template>
    <div class="chart-container">
        <p>Mostrant dades per: '{{ range }}'</p>
        <canvas id="lineChart" ref="canvasRef"></canvas> <!-- Canvas para el gráfico -->
        <p v-if="chartData.length === 0">No hi ha dades per mostrar.</p> <!-- Mensaje si no hay datos -->
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import { Chart } from 'chart.js/auto'; // Importar Chart.js

const props = defineProps({
    range: String, // Rango de fechas (por ejemplo: "hoy", "semana", "mes")
});

const chartData = ref([]); // Datos del gráfico
const canvasRef = ref(null); // Referencia al canvas
const chartInstance = ref(null); // Instancia del gráfico

// Método para obtener los consumos diarios según el rango
const fetchChartData = async (range) => {
    try {
        const authStore = useAuthStore(); // Accede al store de autenticación
        const repteId = authStore.repte.id; // ID del reto actual
        const token = authStore.token; // Token de autenticación
        const maxCalories = authStore.repte.limit_calories_diari; // Máximo de calorías permitido

        // Construir la URL según el rango
        let url = `http://localhost:8000/api/consums/${repteId}`;
        if (range === 'day') {
            url += '?range=today';
        } else if (range === 'week') {
            url += '?range=week';
        } else if (range === 'month') {
            url += '?range=month';
        } else if (range === 'year') {
            url += '?range=year';
        } else {
            console.error('Rango no válido:', range);
            return;
        }

        // Realizar la solicitud
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                Authorization: `Bearer ${token}`,
            },
        });

        if (response.ok) {
            const data = await response.json();

            // Normalizar los datos a porcentajes
            chartData.value = data.map(item => ({
                ...item,
                percentage: (item.calories_consumides / maxCalories) * 100, // Calcular el porcentaje
            }));

            console.log('Datos del gráfico actualizados:', chartData.value);
            renderLineChart(); // Llamar al método para renderizar el gráfico
        } else {
            console.error('Error al obtener los datos del gráfico:', response.statusText);
        }
    } catch (error) {
        console.error('Error en fetchChartData:', error);
    }
};

// Método para renderizar el gráfico de líneas
const renderLineChart = () => {
    const ctx = canvasRef.value.getContext('2d'); // Obtener el contexto del canvas

    // Destruir el gráfico anterior si existe
    if (chartInstance.value) {
        chartInstance.value.destroy();
    }

    // Crear un nuevo gráfico de líneas
    chartInstance.value = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.value.map(item => item.data), // Fechas de los consumos
            datasets: [
                {
                    label: 'Consumo Diario (%)',
                    data: chartData.value.map(item => item.percentage), // Usar los porcentajes calculados
                    borderColor: '#4caf50',
                    backgroundColor: 'rgba(76, 175, 80, 0.2)',
                    borderWidth: 2,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Fecha',
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: 'Porcentaje de Consumo',
                    },
                    beginAtZero: true,
                    max: 100, // Fijar el máximo en 100%
                },
            },
        },
    });
};

// Observar cambios en el rango y actualizar los datos del gráfico
watch(
    () => props.range,
    (newRange) => {
        console.log('Actualizar gráfico por rango:', newRange);
        fetchChartData(newRange); // Llamar al método para obtener los datos
    }
);

// Renderizar el gráfico al montar el componente
onMounted(() => {
    fetchChartData(props.range); // Obtener los datos iniciales
});
</script>
<style scoped>
.chart-container {
    width: 100%;
    height: 400px; /* Altura del gráfico */
    position: relative;
}
.chart-container canvas {
    width: 70% ; /* Asegurar que el canvas ocupe todo el ancho */
    height: 70% ; /* Asegurar que el canvas ocupe toda la altura */
}
.chart-container p {
    text-align: center; /* Centrar el texto */
    font-size: 16px; /* Tamaño de fuente del texto */
    margin-bottom: 10px; /* Espacio entre el texto y el gráfico */
}
</style>