<template>
  <button @click="sendPDF">Enviar gráfico por PDF</button>
</template>

<script setup>



const sendPDF = async () => {
  const authStore = useAuthStore(); // Accede al store de autenticación
  const token = authStore.token; // Token de autenticación

  try {
    // Obtén el canvas del gráfico (asegúrate de que el ID coincida con el del componente Chart.js)
    const canvas = document.getElementById('lineChart');
    if (!canvas) {
      console.error('No se encontró el canvas del gráfico.');
      return;
    }

    // Convierte el canvas a una imagen en formato base64
    const imageBase64 = canvas.toDataURL('image/png');

    // Construye el payload para enviar al backend
    const payload = {
      image: imageBase64, // Imagen en formato base64
    };

    console.log('Payload enviado:', payload);

    // Realiza la solicitud al backend
    const response = await fetch('http://localhost:8000/api/historic/imgToPdf', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
      },
      body: JSON.stringify(payload),
    });

    if (response.ok) {
      console.log('Gráfico enviado correctamente al backend.');
    } else {
      console.error('Error al enviar el gráfico:', response.statusText);
    }
  } catch (error) {
    console.error('Error en imgToPdf:', error);
  }
};
</script>