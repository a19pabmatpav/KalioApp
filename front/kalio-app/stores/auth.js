export const useAuthStore = defineStore('auth', {
  state: () => ({
    username: '',
    token: '',
    repte: '',
    consumDia: 0,
    consumProt: 0,
    consumSuger: 0,
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
      this.consumDia = 0,
      this.consums = [],
      this.authenticated = false
    },
    setRepte(repte) {
      this.repte = repte
    },
    addConsumDia(consumit) {
      console.log("PREConsumit: " + consumit);
      this.consumDia += consumit
      console.log("POSConsumit: " + this.consumDia);      
    },
    addConsumProt(consumProt) {
      console.log("PREConsumProt: " + consumProt);
      this.consumProt += consumProt
      console.log("POSConsumProt: " + this.consumProt);      
    },
    addConsumSuger(consumSuger) {
      console.log("PREConsumSuger: " + consumSuger);
      this.consumSuger += consumSuger
      console.log("POSConsumSuger: " + this.consumSuger);      
    },
    setConsums(historial) {
      console.log("PREConsums: " + historial);
      this.consums.push(historial);
      console.log("POSConsums: " + this.consums);
    }

  },
  getters: {
    isAuthenticated: (state) => !!state.authenticated,
    name: (state) => state.username,
    consumit: (state) => state.consumDia,
    usr_token: (state) => state.token,
  },
  persist: true

})

