<template>
    <form @submit.prevent="register" class="register-form">
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
  
<style scoped >

.register-form button {
    display: flex;
    margin: auto;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    color: white;
    background-color: #FF7A00;
    border-radius: 5px;
    transition: background-color 0.3s;
}

div {
    max-width: 90vw;
}

label {
    display: block;
    margin-bottom: 0.5rem;
}

input {
    width: 90%;
    padding: 0.5rem;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 10px;
    margin-bottom: 1rem;
}
</style>