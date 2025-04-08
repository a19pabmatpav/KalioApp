<template>
  <div>
    <h2>Pregunta a Gemini</h2>
    <div>
      <input type="file" accept="image/*" @change="capturarFoto" />
    </div>
    <!-- <button :disabled="!imagenBase64" @click="consultarGemini">Enviar</button> -->

    <div v-if="respuesta">
      <h3>Resposta:</h3>
      <pre>{{ respuesta }}</pre>
    </div>
  </div>
</template>

<script>
definePageMeta({
  middleware: 'auth',
})

import { enviarConsulta } from "@/services/googleGemini.js";


export default {
  name: "Fotodetector",
  data() {
    return {
      imagenBase64: null,
      respuesta: null,
    };
  },
  methods: {
    capturarFoto(event) {
      const file = event.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = () => {
        this.imagenBase64 = reader.result.split(",")[1]; // quitamos el prefix data:image...
      };
      reader.readAsDataURL(file);
    },

    // async consultarGemini() {
    //   if (!this.imagenBase64) {
    //     console.warn("No hay imagen para analizar");
    //     return;
    //   }

    //   this.respuesta = "Pensant... 🤖";

    //   try {
    //     const respuestaGemini = await enviarConsulta(this.imagenBase64, "image/jpeg");
    //     console.log("Respuesta de Gemini:", respuestaGemini); // ✅ Aquí imprimes la respuesta
    //     this.respuesta = respuestaGemini;
    //   } catch (error) {
    //     console.error("Error consultando Gemini:", error);
    //     this.respuesta = "❌ Error analitzant la imatge";
    //   }
    // },
  },
};
</script>

<style scoped>
input {
  margin-bottom: 10px;
}

button {
  padding: 8px 16px;
  margin-top: 10px;
  cursor: pointer;
}

pre {
  background-color: #eee;
  padding: 10px;
  border-radius: 5px;
  white-space: pre-wrap;
}
</style>