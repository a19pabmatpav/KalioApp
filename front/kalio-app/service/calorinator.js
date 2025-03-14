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
    const foodId = 0;

    // Buscamos el ID del ingrediente
    try {
      const response = await $fetch(`https://api.spoonacular.com/food/ingredients/search?query=${foodItem}`, {
        params: {
          apiKey: process.env.SPOONACULAR_API_KEY,
        },
      });
      foodId = response.results[0].id;
    } catch (error) {
      console.error('Error fetching ingredientID from Spoonacular API:', error);
      return null;
    }


    // Obtenemos la información nutricional del ingrediente
    try {
      const response = await $fetch(`https://api.spoonacular.com/food/ingredients/${foodId}/information?amount=1`, {
        params: {
          apiKey: process.env.SPOONACULAR_API_KEY,
        },
      });
      return response.nutrition.nutrients;
    } catch (error) {
      console.error('Error fetching ingredient data from Spoonacular API:', error);
      return null;
    }
  },

  async getCalories(foodItem, quantity, platOingredient) {
    //const perTraduir = foodItem;
    //const traduit = await this.translateTextEn(perTraduir); // Traducimos el nombre del alimento a inglés


    if (platOingredient === 'plat') {
      // const dishData = await this.getDishNutritionData(foodItem);
      // if (dishData) {
      //   const dish = dishData.results[0];
      //   const totalCalories = dish.nutrition.nutrients.find(nutrient => nutrient.title === 'Calories').amount * quantity;  // Total de calorías basado en la cantidad
      //   return totalCalories;
      // }
      // return null;
      console.log('En construnccion');
      return null;      
    } else {
      const nutritionData = await this.getNutritionData(foodItem);
      if (nutritionData) {
        const caloriesPerGram = nutritionData.find(nutrient => nutrient.name === 'Calories');
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
