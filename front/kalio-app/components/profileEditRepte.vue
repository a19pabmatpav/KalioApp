<template>
    <div class="profile-edit-repte">
        <button class="modBtn" @click="mod = true; del = false">
            <img src="../public/img/pencil-square.svg" alt="">
        </button>
        <button class="delBtn" @click="mod = false; del = true">
            <img src="../public/img/x-square.svg" alt="">
        </button>
        <div class="mod" v-if="mod">

            <div class="modForm">
                <h2>Modifica les dades del Repte:</h2>
                <form @submit.prevent="modificarRepte()">
                    <label for="quant">Qüantitat:</label>
                    <input type="integer" id="quant" name="quant" v-model="quant" required>
                    <label for="final">Finalització:</label>
                    <input type="date" id="final" name="final" v-model="final" required></input>
                    <button type="submit">Modificar</button>
                </form>
            </div>
        </div>
        <div class="del" v-if="del">
            <div class="delConfirm">
                <h2>Estàs segur que vols eliminar aquest repte?</h2>
                <button @click="eliminarRepte()">Sí, eliminar</button>
                <button @click="del = false">Cancel·lar</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProfileEditRepte",
    data() {
        return {
            mod: false,
            del: false,
            quant: null,
            final: null,
        };
    },
    methods: {
        async modificarRepte() {
            // Aquí va la lógica para modificar el repte
            console.log("Modificar repte:", this.quant, this.final);
            // Realiza la llamada a la API o cualquier otra acción necesaria
        },
        async eliminarRepte() {
            const response = await fetch(`http://localhost:8000/api/repte/${this.$route.params.id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                },
            });
        },
    },
};
</script>

<style scoped>
.profile-edit-repte {
    display: flex;
    gap: 10px;
    margin: 0 20vw;
    justify-content: center;
    align-items: center;
}

button {
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50px;
    height: 50px;
    transition: transform 0.2s, background-color 0.2s;
}

button img {
    width: 40px;
    height: 40px;
}

button:hover {
    transform: scale(1.1);
}

.modBtn {
    background-color: #4caf50;
    color: white;
}

.modBtn:hover {
    background-color: #45a049;
}

.delBtn {
    background-color: #f44336;
    color: white;
}

.delBtn:hover {
    background-color: #e53935;
}
</style>