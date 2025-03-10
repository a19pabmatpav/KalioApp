<template>
    <div class="progress-bar">
        <h2>Progress Bar</h2>
        <div class="progress" :style="{ width: progress + '%' }"></div>
    </div>
</template>

<script>
export default {
    name: 'ProgressBar',
    props: {
        progress: {
            type: Number,
            required: true
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