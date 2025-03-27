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
  async getIngredientId(foodItem) {
    const data = await this.makeRequest(`https://api.spoonacular.com/food/ingredients/search`, {
      query: foodItem
    });
    console.log('id del ingrediente encontrado: ' + data?.results?.[0]?.id);
    
    return data?.results?.[0]?.id || 0;
  }

  async getNutritionData(foodItem) {
    const foodId = await this.getIngredientId(foodItem);
    
    if (!foodId) return null;
    
    const data = await this.makeRequest(`https://api.spoonacular.com/food/ingredients/${foodId}/information`, {
      amount: 1
    });
    
    return data?.nutrition?.nutrients || null;
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
      console.log('En construcción');
      return null;
    }else{
      const foodId = await this.ingredientManager.getIngredientId(foodItem);
      console.log('id del ingrediente encontrado: ' + foodId);
      const foodCalories = parseInt(await this.ingredientManager.getNutritionData(foodItem)*quantity);
      console.log('calorias del plato: ' + foodCalories?.results?.[0]?.nutrition?.nutrients?.find(nutrient => nutrient.name === 'Calories')?.amount);
      return foodCalories?.results?.[0]?.nutrition?.nutrients?.find(nutrient => nutrient.name === 'Calories')?.amount;
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