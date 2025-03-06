<!-- pages/login.vue -->
<template>
  <div class="login-page">
    <h1>Login</h1>
    <LoginForm />
  </div>
</template>

<script>

export default {
  components: {
    LoginForm
  }
}
</script>

<style scoped>
.login-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
</style>
