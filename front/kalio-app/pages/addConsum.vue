<template>
    <div>
        <addConsumForm />
    </div>
</template>

<script>
definePageMeta({
  middleware: 'auth'
})
</script>

<style scoped>


div {
    color : white;
  max-width: 77vw;
  max-height: 75vh;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #3C3145;
  background-color:  #3C3145;
  border-radius: 5px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 75vh;
  padding: 20px;
}
</style>
