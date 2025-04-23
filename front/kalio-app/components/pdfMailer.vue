<template>
    <button @click="sendPDF">Enviar gráfico por PDF</button>
  </template>
  
  <script setup>
  const props = defineProps({
    range: String
  })
  
  const sendPDF = async () => {
    // Aquí iría lógica de capturar el gráfico y enviarlo por mail
    console.log('Enviando PDF del rango:', props.range)

    const response = await fetch('localhost:3000/api/send-pdf', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ range: props.range })
    })
    if (response.ok) {
      console.log('PDF enviado con éxito')
    } else {
      console.error('Error al enviar el PDF')
    }
  }
  </script>
  