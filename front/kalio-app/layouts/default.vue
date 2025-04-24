<template>
  <div>
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
    <p>footer</p>
  </div>
</template>

<style scoped>
div {
  background-color: #8A2BE2;
  max-width: 100vw;
  max-height: 100vh;
}

button {
    padding: 10px;
    background-color: #FF7A00;
    border-radius: 5px;
    color: white;
    border: black solid 1px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;

}

button.dropdown-toggle::after {
  display: none !important;
}

p {
  height: 25px;
}
</style>