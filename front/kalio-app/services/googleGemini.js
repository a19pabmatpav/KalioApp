// services/googlegemini.js

export async function enviarConsulta(base64Data, mimeType = "image/jpeg") {
  const API_KEY = 'TU_API_KEY';
  const prompt = "Analiza la foto en busca de platos e ingredientes y respóndeme en formato JSON";

  const body = {
    contents: [
      {
        parts: [
          { text: prompt },
          {
            inline_data: {
              mime_type: mimeType,
              data: base64Data,
            },
          },
        ],
      },
    ],
  };

  try {
    const response = await fetch(
      `https://generativelanguage.googleapis.com/v1beta/models/gemini-pro-vision:generateContent?key=${API_KEY}`,
      {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body),
      }
    );

    const data = await response.json();
    if (data?.candidates?.[0]?.content?.parts?.[0]?.text) {
      return data.candidates[0].content.parts[0].text;
    } else {
      return "❌ No se pudo obtener respuesta.";
    }
  } catch (error) {
    console.error("Error en enviarConsulta:", error);
    return "❌ Error en la llamada a Gemini.";
  }
}
