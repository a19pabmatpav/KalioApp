<template>
    <form @submit.prevent="login">
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
            <button type="submit">Login</button>
        </div>
    </form>
</template>

<script>
const auth = useAuthStore()
const router = useRouter()

export default {
    data() {
        return {
            username: '',
            email: '',
            password: '',
        };
    },
    methods: {
        async login() {
            if (this.username, this.email, this.password) {
                auth.login(this.username, this.email, this.password)
                try {
                    const response = await $fetch('http://localhost:8000/api/login', {
                        method: 'POST',
                        body: JSON.stringify({
                            username: this.username,
                            email: this.email,
                            password: this.password
                        })
                    })
                    if (response.token && response.username) {
                        auth.login(response.username, response.token)

                        router.push('/mainView')
                    } else {
                        alert('Invalid credentials');
                    }
                } catch (error) {
                    console.error(error)

                }
            } else {
                alert('Invalid credentials');
            }
        }
    }
}
</script>