<template>
  <div>
    <h2>Pregunta a Gemini</h2>
    <div>
      <video ref="video" autoplay playsinline></video>
      <button @click="tomarFoto">Capturar Foto</button>
    </div>

    <div v-if="imagenBase64">
      <h3>Imagen Capturada:</h3>
      <img :src="'data:image/jpeg;base64,' + imagenBase64" alt="Imagen Capturada" />
    </div>

    <div v-if="respuesta">
      <h3>Respuesta:</h3>
      <pre>{{ respuesta }}</pre>
    </div>
  </div>
</template>

<script>
definePageMeta({
  middleware: 'auth',
})

export default {
  name: "Fotodetector",
  data() {
    return {
      imagenBase64: null,
      respuesta: null,
      videoStream: null,
    };
  },
  mounted() {
    this.iniciarCamara();
  },
  beforeDestroy() {
    this.detenerCamara();
  },
  methods: {
    async iniciarCamara() {
      try {
        // Solicitar acceso a la cámara
        this.videoStream = await navigator.mediaDevices.getUserMedia({ video: true });
        const videoElement = this.$refs.video;
        videoElement.srcObject = this.videoStream;
      } catch (error) {
        console.error("Error al acceder a la cámara:", error);
      }
    },
    detenerCamara() {
      if (this.videoStream) {
        const tracks = this.videoStream.getTracks();
        tracks.forEach((track) => track.stop());
      }
    },
    tomarFoto() {
      const videoElement = this.$refs.video;
      const canvas = document.createElement("canvas");
      canvas.width = videoElement.videoWidth;
      canvas.height = videoElement.videoHeight;

      const context = canvas.getContext("2d");
      context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

      // Convertir la imagen a Base64
      this.imagenBase64 = canvas.toDataURL("image/jpeg").split(",")[1];
    },
  },
};
</script>

<style scoped>
video {
  width: 100%;
  max-width: 400px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-bottom: 10px;
}

button {
  padding: 8px 16px;
  margin-top: 10px;
  cursor: pointer;
}

img {
  max-width: 100%;
  margin-top: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

pre {
  background-color: #eee;
  padding: 10px;
  border-radius: 5px;
  white-space: pre-wrap;
}
</style>