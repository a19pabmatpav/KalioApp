export const useAuthStore = defineStore('auth', {
  state: () => ({
    username: '',
    token: '',
    repte: '',
    authenticated: false
  }),
  actions: {
    login(username, token) {
      this.username = username
      this.token = token
      this.authenticated = true
    },
    logout() {
      this.authenticated = false
    },
    setRepte(repte) {
      this.repte = repte
    }

  },
  getters: {
    isAuthenticated: (state) => !!state.authenticated
  }
  
})

