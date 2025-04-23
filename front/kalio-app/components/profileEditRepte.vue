<template>
    <div class="profile-edit-repte">
        <button class="modBtn" @click="mod = true; del = false">
            <img src="../public/img/pencil-square.svg" alt="">
        </button>
        <button class="delBtn" @click="mod = false; del = true">
            <img src="../public/img/x-square.svg" alt="">
        </button>
    </div>
    <div class="formulariRepte">
        <FormRepte v-if="mod"/>
    </div>
    <div class="del" v-if="del">
        <div class="delConfirm">
            <h2>Estàs segur que vols eliminar aquest repte?</h2>
            <div class="del-buttons">
                <button class="cancelBtn" @click="del = false">No</button>
                <button class="confirmDelBtn" @click="eliminarRepte()">Sí</button>
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
        async eliminarRepte() {
            const authStore = useAuthStore(); // Llama directamente a useAuthStore()
            const token = authStore.token; // Accede al token desde el store
            const user = authStore.username; // Accede al nombre del usuario desde el store
            const repte_id = authStore.repte.id; // Accede al ID del reto desde el store

            const response = await fetch(`http://localhost:8000/api/reptes/${repte_id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,

                },
            });
            if (response.ok) {
                console.log("Repte eliminat amb èxit");
                del = false; // Oculta la confirmación de eliminación
                authStore.setRepte(null); // Limpia el reto del store
                this.$router.push('/profile'); // Redirige a la página de perfil después de eliminar el reto
            } else {
                console.error("Error en eliminar el repte:", response.statusText);
            }
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

.del-buttons {
    display: flex;
    gap: 10px; /* Espacio entre los botones */
    justify-content: center;
    align-items: center;
}

.formulariRepte {
    margin: 20px 20px 20px 20px; 
}

h2 {
    color: white;
    text-align: center;
    margin-top: 20px; 
    margin-bottom: 20px; /* Espacio entre el texto y los botones */
    font-size: 1.5rem; /* Tamaño de fuente del texto */
}

.cancelBtn {
    background-color: #e0e0e0; /* Gris claro */
    color: black;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    border: none;
}

.cancelBtn:hover {
    background-color: #d6d6d6; /* Gris más oscuro al pasar el cursor */
}

.confirmDelBtn {
    background-color: #f44336; /* Rojo */
    color: black;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    border: none;
    border-color: solid black 1px;
}

.confirmDelBtn:hover {
    background-color: #e53935; /* Rojo más oscuro al pasar el cursor */
}
</style>