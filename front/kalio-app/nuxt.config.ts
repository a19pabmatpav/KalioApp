// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  ssr: false,
  compatibilityDate: '2025-03-10',
  devtools: { enabled: true },
  modules: [
    '@pinia/nuxt',
  ],
  
})