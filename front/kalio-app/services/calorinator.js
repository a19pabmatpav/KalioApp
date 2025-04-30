import { useRuntimeConfig } from '#imports';
import { useFetch } from '#app';

// Clase base para manejar solicitudes API
class ApiClient {
  constructor() {
    this.config = useRuntimeConfig();
    this.apiKey = this.config.public.SPOONACULAR_API_KEY;
  }

  async makeRequest(url, params = {}) {
    try {
      const { data, error } = await useFetch(url, {
        params: {
          apiKey: this.apiKey,
          ...params
        }
      });
      
      if (error.value) throw error.value;
      return data.value;
    } catch (error) {
      console.error(`Error making API request to ${url}:`, error);
      return null;
    }
  }
}

// Clase para manejar operaciones de platos
class DishManager extends ApiClient {
  async getNutritionData(dish) {
    return await this.makeRequest('https://api.spoonacular.com/recipes/complexSearch', {
      query: dish,
      number: 1,
      addRecipeInformation: true,
      language: 'en',
    });
  }
}

// Clase para manejar operaciones de ingredientes
class IngredientManager extends ApiClient {
  // Obtiene el ID del ingrediente
  async getIngredientId(foodItem) {
    const data = await this.makeRequest(`https://api.spoonacular.com/food/ingredients/search`, {
      query: foodItem,
      number: 1
    });
    const foodId = data?.results?.[0]?.id;
    console.log('🆔 ID del ingrediente encontrado:', foodId);
    return foodId || 0;
  }

  // Obtiene las calorías del ingrediente
  async getNutritionData(foodItem) {
    const foodId = await this.getIngredientId(foodItem);
    if (!foodId) return null;

    const data = await this.makeRequest(`https://api.spoonacular.com/food/ingredients/${foodId}/information`, {
      amount: 1
    });
    console.log(data);
    
    const calories = data?.nutrition?.nutrients?.find(nutrients => nutrients.name === 'Calories')?.amount;
    const proteins = data?.nutrition?.nutrients?.find(nutrients => nutrients.name === 'Protein')?.amount;
    const sugars = data?.nutrition?.nutrients?.find(nutrients => nutrients.name === 'Sugar')?.amount;
    const dades = {
      calories: calories || null,
      proteins: proteins || null,
      sugars: sugars || null
    }
    console.log('🔥 Datos del ingrediente:', calories, proteins, sugars);
    return dades || null;
  }
}

// Clase principal que integra todas las funcionalidades
class Calorinator {
  constructor() {
    this.dishManager = new DishManager();
    this.ingredientManager = new IngredientManager();
  }

  async getDishNutritionData(dish) {
    return await this.dishManager.getNutritionData(dish);
  }

  async getNutritionData(foodItem) {
    return await this.ingredientManager.getNutritionData(foodItem);
  }

  async getCalories(foodItem, quantity, platOingredient) {
    if (platOingredient === 'plat') {
      console.log('🚧 Funcionalidad en construcción para platos.');
      return null;
    } else {
      console.log(`📦 Obteniendo calorías de ${quantity} unidad(es) de ${foodItem}.`);
      const caloriesPerUnit = await this.ingredientManager.getNutritionData(foodItem);
      const proteinsPerUnit = await this.ingredientManager.getNutritionData(foodItem);
      const sugarsPerUnit = await this.ingredientManager.getNutritionData(foodItem);
      if (caloriesPerUnit === null) {
        console.error('❌ No se pudo obtener la información nutricional.');
        return null;
      }
      console.log(caloriesPerUnit, proteinsPerUnit, sugarsPerUnit);
      
      const totalCalories = caloriesPerUnit * quantity;
      const totalProteins = proteinsPerUnit * quantity;
      const totalSugars = sugarsPerUnit * quantity;
      const nutritionalData = {
        calories: totalCalories,
        proteins: totalProteins,
        sugars: totalSugars
      };
      console.log(`🍽️ Información nutricional para ${quantity} unidad(es) de ${foodItem}: ${JSON.stringify(nutritionalData)}`);
      

      return parseInt(nutritionalData);
    }
  }
}

// Hook composable para utilizar en componentes Vue
export const useCalorinator = () => {
  const calorinator = new Calorinator();

  return {
    async getDishNutritionData(dish) {
      return await calorinator.getDishNutritionData(dish);
    },
    async getNutritionData(foodItem) {
      return await calorinator.getNutritionData(foodItem);
    },
    async getCalories(foodItem, quantity, platOingredient) {
      return await calorinator.getCalories(foodItem, quantity, platOingredient);
    }
  };
};
