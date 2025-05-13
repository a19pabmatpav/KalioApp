<template>
    <div>
        <img src="../public/img/kalioMonsterCopy.png" alt="Kalio Monster" />
    </div>
</template>

<script>
export default {
    name: 'Kalio',
    data() {
        return {
            // Your component data here
        };
    },
    methods: {
        
    },
    computed: {
        // Your computed properties here
    },
    mounted() {
        // Your mounted hook here
    }
};
</script>

<style scoped>
img {
    max-width: 70vw;
    max-height: 70vh;
    margin: auto;
    display: block;
    border-radius: 50%; /* Hace la imagen circular */
    object-fit: cover; /* Asegura que la imagen se ajuste correctamente dentro del círculo */
}
</style>