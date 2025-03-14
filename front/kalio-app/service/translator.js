export default {
    async translateTextCat(text, targetLanguage = 'ca') {
        try {
          const response = await $fetch('https://translation.googleapis.com/language/translate/v2', {
            method: 'POST',
            body: JSON.stringify({
              q: text,
              target: targetLanguage, // Idioma de destino (por ejemplo, 'ca' para catalán)
              key: process.env.GOOGLE_API_KEY,  // Asegúrate de configurar esta clave en tus variables de entorno
            }),
          });
          return response.data.translations[0].translatedText;
        } catch (error) {
          console.error('Error translating text:', error);
          return text; // Si ocurre un error, devuelve el texto original
        }
      },
    async translateTextEn(text, targetLanguage = 'en') {
        try {
            const response = await $fetch('https://translation.googleapis.com/language/translate/v2', {
              method: 'POST',
              body: JSON.stringify({
                q: text,
                target: targetLanguage, // Idioma de destino (por ejemplo, 'en' para ingles)
                key: process.env.GOOGLE_API_KEY,  // Asegúrate de configurar esta clave en tus variables de entorno
              }),
            });
            return response.data.translations[0].translatedText;
          } catch (error) {
            console.error('Error translating text:', error);
            return text; // Si ocurre un error, devuelve el texto original
          }
        },
}