<template>
    <form @submit.prevent="register">
      <div>
        <label for="username">Username</label>
        <input v-model="username" type="text" id="username" required />
      </div>
      <div>
        <label for="email">Email</label>
        <input v-model="email" type="email" id="email" required />
      </div>
      <div>
        <label for="password">Password</label>
        <input v-model="password" type="password" id="password" required />
      </div>
      <div>
        <button type="submit">Register</button>
      </div>
    </form>
  </template>
  
  <script>
  export default {
    data() {
      return {
        username: '',
        email: '',
        password: '',
      };
    },
    methods: {
      register() {
        // Aquí puedes hacer una llamada a una API para autenticar al usuario
        if (this.username === 'admin' && this.password === 'password') {
          this.$router.push('/dashboard'); // Redirigir al dashboard
        } else {
          alert('Invalid credentials');
        }
      }
    }
  }
  </script>
  