export const useAuthStore = defineStore('auth', {
  state: () => ({
    username: '',
    token: '',
    repte: '',
    consumDia: [],
    consums: [],
    authenticated: false
  }),
  actions: {
    login(username, token) {
      this.username = username
      this.token = token
      this.authenticated = true
    },
    logout() {
      this.username = '',
      this.token = '',
      this.repte = '',
      this.consumDia = '',
      this.consums = [],
      this.authenticated = false
    },
    setRepte(repte) {
      this.repte = repte
    },
    addConsumDia(consumit) {
      this.consumDia += consumit
    },
    setConsums(historial) {
      this.consums = historial
    }

  },
  getters: {
    isAuthenticated: (state) => !!state.authenticated,
    name: (state) => state.username,
  }

})

