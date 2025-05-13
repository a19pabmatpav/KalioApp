<template>
    <div class="progress-bar-container">
        <img class="flag-left" src="../public/img/flag.svg" alt="Inicio" />
        <div class="progress-bar">
            <div class="progress" :style="{ width: barraProgres + '%' }"></div>
        </div>
        <img class="flag-right" src="../public/img/flag-fill.svg" alt="Fin" />
    </div>
</template>

<script>
const authStore = useAuthStore();

export default {
    name: 'ProgressBar',
    computed: {
        barraProgres() {
            const maxCalories = authStore.repte.limit_calories_diari || 0; // Obtener el máximo de calorías
            const consumedCalories = authStore.consumit; // Obtener las calorías consumidas
            console.log(consumedCalories);
            const progress = (consumedCalories / maxCalories) * 100;

            return Math.min(progress, 100);
        }
    },
};
</script>

<style scoped>
/* Contenedor principal de la barra de progreso */
.progress-bar-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 60vw;
    margin: 0 auto;
    margin-bottom: 2vh;
    position: relative;
}

/* Estilo para los flags */
.flag-left,
.flag-right {
    width: 30px;
    height: 30px;
}

/* Contenedor de la barra de progreso */
.progress-bar {
    flex: 1;
    height: 20px;
    background-color: #e0e0e000; /* Color de fondo de la barra */
    border-radius: 10px;
    position: relative;
    margin: 0 10px; /* Espaciado entre los flags y la barra */
    overflow: hidden;
}

/* Barra de progreso */
.progress {
    height: 100%;
    background-color: #FF7A00; /* Color de la barra de progreso */
    transition: width 0.3s ease;
}
</style>