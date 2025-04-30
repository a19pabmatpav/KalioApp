<template>
  <button @click="sendPDF">Enviar gráfico por PDF</button>
</template>

<script setup>
const props = defineProps({
  range: String,
  chartElement: Object
})

const sendPDF = () => {
  if (!props.chartElement) {
    console.warn('No se encontró el componente Chart')
    return
  }

  html2pdf()
    .from(props.chartElement)
    .set({
      margin: 1,
      filename: `grafico-${props.range}.pdf`,
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: { scale: 2 },
      jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    })
    .save()
}
</script>