<template>
  <div class="layout-container">
    <div class="dropdown">
      <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
        data-bs-auto-close="outside">
        <img src="../public/img/list.svg" alt="menu" srcset="">
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" @click="() => $router.push('/mainView')">Inici</a></li>
        <li><a class="dropdown-item" @click="() => $router.push('/profile')">Perfil</a></li>
        <li><a class="dropdown-item" @click="() => $router.push('/history')">Veure històric</a></li>
        <li><a class="dropdown-item" @click="() => $router.push('/logOut')">Tancar sessió</a></li>
      </ul>
    </div>
    <slot />
  </div>
</template>

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
  padding: 10px;
  margin: 10px;
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