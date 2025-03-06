<template>
  <div class="loginCard">
    <div class="tabs">
      <button @click="showLogin" :class="{ active: isLogin }">Login</button>
      <button @click="showRegister" :class="{ active: !isLogin }">Register</button>
    </div>

    <div class="login-page" v-if="isLogin">
      <h1>Login</h1>
      <loginForm />
    </div>

    <div class="register-page" v-if="!isLogin">
      <h1>Registre</h1>
      <registerForm />
    </div>
  </div>
</template>

<script setup>
const isLogin = ref(true)

const showLogin = () => {
  isLogin.value = true
}

const showRegister = () => {
  isLogin.value = false
}

</script>

<style scoped>
.loginCard {
  color : white;
  max-width: 77vw;
  max-height: 75vh;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #3C3145;
  background-color:  #3C3145;
  border-radius: 5px;
}

.tabs {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-bottom: 20px;
}

button {
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  color: white;
  background-color: #2D1B52;
  border-radius: 8px;
  transition: background-color 0.3s;
}

button.active {
  background-color: #FF7A00;
  color: white;
}

.login-page,
.register-page {
  
  display: block;
  justify-content: center;
  align-items: center;
  height: 75vh;
}

.login-page h1,
.register-page h1 {
  margin-top: 50px;
  margin-bottom: 20px;
  text-align: center;
}
</style>
