<template>
    <div class="profile-data">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item" v-for="(item, index) in items" :key="index" :class="{ active: index === 0 }">
                    <div class="text-center p-4">
                        <img :src="item.icono" class="d-block mx-auto mb-3" :alt="item.nombre"
                            style="width: 100px; height: 100px;" />
                        <h5>{{ item.nombre }}</h5>
                        <p>{{ item.descripcion }}</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </div>
</template>

<script>

export default {
    name: "ProfileData",
    setup() {
        const items = ref([]);
        const error = ref(null);

        // Obtener el ID del usuario desde el store de Pinia
        const userStore = useAuthStore();
        const username = userStore.username; 
        const token = userStore.token;

        // Obtener los datos al montar el componente
        onMounted(async () => {
            const { data, error: fetchError } = await useFetch(`http://localhost:8000/api/logros/${username}`, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            if (fetchError.value) {
                console.error('Error fetching data:', fetchError.value);
                error.value = fetchError.value;
            } else {
                console.log('Fetched items:', data.value);
                items.value = data.value;
            }
        });

        return {
            items,
            error,
        };
    },
};
</script>

<style scoped>
/* Estilos específicos del componente */
.carousel-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.carousel-item img {
    border-radius: 50%;
    object-fit: cover;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
}
</style>