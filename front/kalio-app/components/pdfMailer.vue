<template>
  <button @click="sendPDF">Enviar gráfico por PDF</button>
</template>

<script setup>
import * as html2pdf from 'html2pdf.js';

// Definición de props
const props = defineProps({
  range: {
    type: String,
    required: true,
  },
  chartElement: {
    type: Object,
    required: true,
  },
});

let html2pdfLib = null;

onMounted(() => {
  // Inicializar html2pdf solo una vez
  if (process.client && !html2pdfLib) {
    html2pdfLib = window.html2pdf;
  }
});
// Método para generar y descargar el PDF
const sendPDF = () => {
  if (!props.chartElement) {
    console.warn('No se encontró el elemento del gráfico');
    return;
  }

  try {
    html2pdfLib()
      .from(props.chartElement)
      .set({
        margin: 1,
        filename: `grafico-${props.range}.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
      })
      .save();
  } catch (error) {
    console.error('Error al generar el PDF:', error);
  }
};
</script>