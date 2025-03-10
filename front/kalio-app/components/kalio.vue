<template>
    <div>
        <img src="../public/img/kalioMonster.webp" alt="" srcset="">
        <button><img src="../public/img/plus.svg" alt="" srcset=""></button>
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
        // Your component methods here
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
    max-height: 75vh;
    margin: auto;
    display: block;
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
</style>