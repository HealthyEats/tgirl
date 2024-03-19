document.getElementById("getRecipe").addEventListener("click", function() {
    const ingredients = document.getElementById("ingredients").value;
    fetchRecipe(ingredients);
});

function fetchRecipe(ingredients) {
    const appId = "YOUR_REAL_APP_ID";
    const appKey = "YOUR_REAL_APP_KEY";
    const url = `https://api.edamam.com/search?q=${encodeURIComponent(ingredients)}&app_id=${appId}&app_key=${appKey}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            displayRecipes(data.hits);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function displayRecipes(recipes) {
    const recipeList = document.getElementById("recipeList");
    recipeList.innerHTML = "";

    recipes.forEach(recipe => {
        const recipeItem = document.createElement("div");
        recipeItem.classList.add("recipe");
        recipeItem.innerHTML = `
            <h2>${recipe.recipe.label}</h2>
            <img src="${recipe.recipe.image}" alt="${recipe.recipe.label}">
            <ul>
                ${recipe.recipe.ingredients.map(ingredient => `<li>${ingredient.text}</li>`).join('')}
            </ul>
        `;
        recipeList.appendChild(recipeItem);
    });
}

