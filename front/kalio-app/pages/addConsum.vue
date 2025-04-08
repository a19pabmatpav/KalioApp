<template>
  <div>
    <h1>Afegir consum</h1>
    <button @click=formulari>Afegir manualment</button>
    <button @click=detector>Fotodetector</button>
  </div>
  <div>
    <addConsumForm v-if:actiu="formulari" />
    <fotodetector v-if:actiu="detector" />
  </div>
</template>

<script>
definePageMeta({
  middleware: 'auth'
})

export default {
  data() {
    return {
      actiu: '',
    }
  },
  methods: {
    formulari() {
      this.actiu = 'formulari';
    },
    detector() {
      this.actiu = 'fotodetector';
    }
  }

}

</script>

<style scoped>
div {
  color: white;
  max-width: 77vw;
  max-height: 75vh;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #3C3145;
  background-color: #3C3145;
  border-radius: 5px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 75vh;
  padding: 20px;
}
</style>
