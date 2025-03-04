<script setup>
definePageMeta({
  layout: 'admin'
})

const greeting = ref('Hello World!')

</script>

<template>
  <p class="greeting">{{ greeting }}</p>

  
y aqui un ComponentPublicInstance
<helloWorld />
</template>

<style>
.greeting {
  color: red;
  font-weight: bold;
}
</style>