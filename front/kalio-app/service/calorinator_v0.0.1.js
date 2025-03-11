const axios = require('axios');

async function getCalories(foodItem, quantity) {
    try {
        const response = await fetch(`https://world.openfoodfacts.org/api/v0/product/${foodItem}.json`);
        const caloriesPerGram = response.data.calories_per_gram;
        const totalCalories = caloriesPerGram * quantity;
        return totalCalories;
    } catch (error) {
        console.error('Error fetching data from API:', error);
        return null;
    }
}

// Example usage
const foodItem = 'apple';
const quantity = 150; // in grams

getCalories(foodItem, quantity).then(totalCalories => {
    if (totalCalories !== null) {
        console.log(`Total calories for ${quantity} grams of ${foodItem}: ${totalCalories}`);
    } else {
        console.log('Could not fetch calorie information.');
    }
});