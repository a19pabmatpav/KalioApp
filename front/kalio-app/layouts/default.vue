<template>
  <div class="layout-container">
    <div class="dropdown" ref="dropdown">
      <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
        data-bs-auto-close="outside">
        <img src="../public/img/list.svg" alt="menu" />
      </button>
      <ul class="dropdown-menu">
        <li>
          <a class="dropdown-item" @click="navigateAndClose('/mainView')">
            Inici
          </a>
        </li>
        <li>
          <a class="dropdown-item" @click="navigateAndClose('/profile')">
            Perfil
          </a>
        </li>
        <li>
          <a class="dropdown-item" @click="navigateAndClose('/history')">
            Veure històric
          </a>
        </li>
        <li>
          <a class="dropdown-item" @click="navigateAndClose('/login')">
            Tancar sessió
          </a>
        </li>
      </ul>
    </div>
    <slot />
  </div>
</template>

<script>
export default {
  methods: {
    navigateAndClose(route) {
      const authStore = useAuthStore();
      authStore.logout(); // Llamar directamente a la función logout

      // Navegar a la ruta
      this.$router.push(route);

      // Cerrar el menú
      const dropdown = this.$refs.dropdown.querySelector('.dropdown-menu');
      if (dropdown) {
        dropdown.classList.remove('show');
      }
    },
  },
};
</script>

<style scoped>
/* Contenedor principal que llena toda la página */
.layout-container {
  background-color: #8A2BE2;
  width: 100vw;
  height: 100vh;
  overflow: scroll;
}

/* Botón del menú */
button {
  margin: 10px;
  padding: 10px;
  background-color: #FF7A00;
  border-radius: 5px;
  color: white;
  border: black solid 1px;
  cursor: pointer;
  transition: background 0.3s;
}

/* Ocultar el indicador del dropdown */
button.dropdown-toggle::after {
  display: none !important;
}

/* Footer */
p {
  height: 25px;
  margin: 0;
  text-align: center;
  color: white;
}
</style>