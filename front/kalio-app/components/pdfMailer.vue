<template>
  <button @click="sendPDF">Enviar gráfico por PDF</button>
</template>

<script setup>
console.log('Token en pinia antes de empezar:', useAuthStore().usr_token); // Verifica el token antes de enviar el PDF

const sendPDF = async () => {
  const authStore = useAuthStore(); // Accede al store de autenticación
  const token = authStore.usr_token; // Accede al token a través del getter

  console.log('Token obtenido desde el getter usr_token:', token); // Depuración

  try {
    // Obtén el canvas del gráfico (asegúrate de que el ID coincida con el del componente Chart.js)
    const canvas = document.getElementById('lineChart');
    if (!canvas) {
      console.error('No se encontró el canvas del gráfico.');
      return;
    }

    // Convierte el canvas a un Blob
    canvas.toBlob(async (blob) => {
      if (!blob) {
        console.error('No se pudo convertir el canvas a Blob.');
        return;
      }

      // Construye un FormData para enviar el Blob al backend
      const formData = new FormData();
      formData.append('image', blob, 'chart.png'); // Agrega el Blob al FormData

      console.log('Blob generado:', blob);

      // Realiza la solicitud al backend
      const response = await fetch('http://localhost:8000/api/historic/imgToPdf', {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${token}`, // Token de autenticación
        },
        body: formData, // Enviar el FormData
      });

      if (response.ok) {
        console.log('Gráfico enviado correctamente al backend.');
      } else {
        console.error('Error al enviar el gráfico:', response.statusText);
      }
    }, 'image/png'); // Especifica el formato de la imagen
  } catch (error) {
    console.error('Error en sendPDF:', error);
  }
};
</script>