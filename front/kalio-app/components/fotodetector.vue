<template>
    <div class="detector">
      <h1>Afegir consum</h1>
      
    </div>
  </template>
  
  <script>
  export default {
    name: 'fotodetector',
    data() {
      return {
        alimento: '',
        alimentos: [],
        liquido: 'agua',
        liquidos: [],
      };
    },
    methods: {
      agregarAlimento() {
        this.alimentos.push({
          alimento: this.alimento,
        });
        this.alimento = '';
      },
      agregarLiquido() {
        this.liquidos.push({
          liquido: this.liquido,
          cantidad: this.cantidadLiquido,
        });
        this.liquido = 'agua';
        this.cantidadLiquido = 0;
      },
    },
  };
  </script>
  
  <style scoped>
  .detector {
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
  }
  
  .detector h1 {
    color: white;
    font-size: 2em;
    margin-bottom: 20px;
  }
  
  .detector button {
    background-color: #3C3145;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
  }
  
  .detector button:hover {
    background-color: #5A4B8A;
  }
  </style>
  