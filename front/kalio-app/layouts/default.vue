<template>
    <div>
      <p>header</p>
      <slot />
      <p>footer</p>
    </div>
  </template>

 <style scoped>
 div{
  background-color: #8A2BE2;
  max-width: 100vw;
  max-height: 100vh;
 }
    p {
      height: 25px;
    }
</style>