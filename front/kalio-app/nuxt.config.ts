// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  app: {
    head: {
      script: [
        {
          src: 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
          integrity: 'sha384-...pon aquí el hash si lo deseas...',
          crossorigin: 'anonymous'
        }
      ],
      title: 'Kalio',
      meta: [
        { name: 'description', content: 'Kalio - Your Personal Recipe Assistant' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      ],
      link: [
        { rel: 'icon', type: 'image/x-icon', href: '/kalio-logo.png' }
      ],
    }
  },
  css: ['bootstrap/dist/css/bootstrap.min.css'],
  ssr: false,
  compatibilityDate: '2025-03-10',
  devtools: { enabled: true },
  modules: [
    '@pinia/nuxt',
  ],
  runtimeConfig: {
    public: {
      SPOONACULAR_API_KEY: process.env.SPOONACULAR_API_KEY,
      GOOGLE_API_KEY: process.env.GOOGLE_API_KEY,
    }
  }
})