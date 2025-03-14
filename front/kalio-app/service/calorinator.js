export default {
  async getDishNutritionData(dish) {
    try {
      const response = await $fetch('https://api.spoonacular.com/recipes/complexSearch', {
        params: {
          apiKey: process.env.SPOONACULAR_API_KEY,  // Tu clave API de Spoonacular
          query: dish,  // Nombre de la receta, por ejemplo 'paella'
          number: 1,  // Número de resultados a devolver
          addRecipeInformation: true,  // Incluir detalles adicionales de la receta
          language: 'en',  // Idioma de la receta (en este caso inglés)
        },
      });
      return response;
    } catch (error) {
      console.error('Error fetching data from Spoonacular API:', error);
      return null;
    }
  },
  async getNutritionData(foodItem) {
    try {
      const response = await $fetch(`https://api.spoonacular.com/food/ingredients/${foodItem}/information`, {
        params: {
          apiKey: process.env.SPOONACULAR_API_KEY,  // Asegúrate de configurar esta clave en tus variables de entorno
          language: 'en',  // Devuelve la información en inglés
        },
      });
      return response;
    } catch (error) {
      console.error('Error fetching data from Spoonacular API:', error);
      return null;
    }
  },

  async getCalories(foodItem, quantity, platOingredient) {
    if (platOingredient === 'plat') {
      const dishData = await this.getDishNutritionData(foodItem);
      if (dishData) {
        const dish = dishData.results[0];
        const totalCalories = dish.nutrition.nutrients.find(nutrient => nutrient.title === 'Calories').amount * quantity;  // Total de calorías basado en la cantidad
        return totalCalories;
      }
      return null;
    } else {
      const nutritionData = await this.getNutritionData(foodItem);

    if (nutritionData) {
      const caloriesPerGram = nutritionData.nutrition.nutrients.find(nutrient => nutrient.title === 'Calories');
      if (caloriesPerGram) {
        const totalCalories = caloriesPerGram.amount * quantity;  // Total de calorías basado en la cantidad
        return totalCalories;
      }
      return null;
    }
    return null;
    }
  },
};
