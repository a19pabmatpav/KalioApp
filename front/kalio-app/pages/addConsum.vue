<template>
  <div class="contenedor">
    <h1>Afegir consum</h1>
    <!-- <button @click="toggleFormulari">Afegir manualment</button> -->
    <!-- <button @click="toggleDetector">Fotodetector</button> -->

    <!-- Render dinámico con transición -->

    <addConsumForm v-if="formulariActiu" />

    <!-- <transition name="fade">
      <fotodetector v-if="detectorActiu" />
    </transition> -->
  </div>
</template>

<script>
definePageMeta({
  middleware: 'auth',
})

export default {
  data() {
    return {
      formulariActiu: true,
      // detectorActiu: false,
    };
  },
  methods: {
    toggleFormulari() {
      this.formulariActiu = !this.formulariActiu;
      if (this.formulariActiu) this.detectorActiu = false;
    },
    // toggleDetector() {
    //   this.detectorActiu = !this.detectorActiu;
    //   if (this.detectorActiu) this.formulariActiu = false;
    // },
  },
};
</script>

<style scoped>
.contenedor {
  color: white;
  width: 77vw;
  height: 75vh;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #3C3145;
  background-color: #3C3145;
  border-radius: 5px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: start;
  gap: 20px;
  min-height: auto;
}

/* Transiciones suaves */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* button {
    padding: 10px;
    background-color: #FF7A00;
    border-radius: 5px;
    color: white;
    border: none;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background-color: #e66a00;
} */
</style>
