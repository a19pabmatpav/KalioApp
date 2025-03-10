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

<script setup>
const auth = useAuthStore()
const router = useRouter()


const username = ref('')
const email = ref('')
const password = ref('')

// Función para el login
const register = async () => {
    if (username.value && email.value && password.value) {
        console.log(username.value, email.value, password.value);
        try {
            
            const response = await $fetch('http://localhost:8000/api/register', {
                method: 'POST',
                body: JSON.stringify({
                    username: username.value,
                    email: email.value,
                    password: password.value
                })
            })

            if (response.token && response.username) {
                // Guardamos el token y el nombre de usuario en el store
                auth.login(response.username, response.token, response.repte)
                localStorage.setItem('authUsername', response.user.name)
                localStorage.setItem('authToken', response.access_token)

                router.push('/repte')
            } else {
                alert('Invalid credentials')
            }
        } catch (error) {
            console.error('Error durante el registro:', error)
            alert('Hubo un error durante el registro.')
        }
        } else {
        alert('Por favor, complete todos los campos.')
    }
}
</script>

<style scoped>
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