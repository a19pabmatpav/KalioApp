<template>
    <div class="progress-bar">
        <img src="../public/img/flag.svg" alt="" srcset="">
        <div class="progress" :style="{ width: barraProgres + '%' }"></div><img src="../public/img/flag-fill.svg" alt=""
            srcset="">
    </div>
</template>

<script>
const authStore = useAuthStore()


export default {
    name: 'ProgressBar',
    computed: {
        barraProgres() {
            const maxCalories = authStore.repte.limit_calories_diari || 0;  // Obtener el máximo de calorías
            const consumedCalories = authStore.consumit;  // Obtener las calorías consumidas
            console.log(consumedCalories);
            const progress = (consumedCalories / maxCalories) * 100;

            return Math.min(progress, 100);
        }
    },
}
</script>

<style scoped>
.progress-bar {
    display: flex;
    position: relative;
    align-items: center;
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