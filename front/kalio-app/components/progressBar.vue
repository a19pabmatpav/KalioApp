<template>
    <div class="progress-bar">
        <h2>Progress Bar</h2>
        <div class="progress" :style="{ width: barraProgres + '%' }"></div>
    </div>
</template>

<script>
const authStore = useAuthStore()


export default {
    name: 'ProgressBar',
    computed: {
        barraProgres() {
            const maxCalories = authStore.repte?.limit_calories_diari || 0;  // Obtener el máximo de calorías
            let consumedCalories = authStore.consumDia || 0;  // Obtener las calorías consumidas
            const progress = (consumedCalories / maxCalories) * 100;
            return Math.min(progress, 100);
        }
    }
}
</script>

<style scoped>
.progress-bar {
    width: 60vw;
    overflow: hidden;
    margin: 0 auto;
    margin-bottom: 2vh;
}

.progress {
    height: 20px;
    border-radius: 10px;
    background-color: #FF7A00;
    transition: width 0.3s ease;
}
</style>