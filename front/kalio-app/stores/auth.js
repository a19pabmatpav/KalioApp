export const useAuthStore = defineStore('auth', {
  state: () => ({
    username: '',
    token: '',
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
    }
    
  },
  getters: {
    isAuthenticated: (state) => !!state.authenticated
  }
})
