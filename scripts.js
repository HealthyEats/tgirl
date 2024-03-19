// scripts.js
function translateText(textToTranslate) {
    // Use API_ID and API_KEY variables from config.js
    var url = `https://api.mymemory.translated.net/get?q=${encodeURIComponent(textToTranslate)}&langpair=ar|en&de=${API_ID}&key=${API_KEY}`;

    return fetch(url)
        .then(response => response.json())
        .then(data => {
            return data.responseData.translatedText;
        })
        .catch(error => {
            console.error('Error:', error);
            return null;
        });
}

document.getElementById("time-range").addEventListener("input", function() {
    var time = this.value;
    document.getElementById("time-label").textContent = time + " minutes (How much time do you have?)";
});

document.getElementById("recipe-button").addEventListener("click", function() {
    const time = document.getElementById("time-range").value;
    const ingredientsInput = document.getElementById("ingredients-input");
    const ingredients = ingredientsInput.value;

    // Translate ingredients to English
    translateText(ingredients)
        .then(translatedIngredients => {
            if (translatedIngredients) {
                const defaultPreparationTime = time; // Set default preparation time
                const appId = API_ID;
                const appKey = API_KEY;
                const url = `https://api.edamam.com/search?q=${translatedIngredients}&app_id=${appId}&app_key=${appKey}&time=${time}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const recipeList = document.getElementById("recipe-list");
                        recipeList.innerHTML = "";

                        data.hits.forEach(hit => {
                            const recipe = hit.recipe;

                            const recipeItem = document.createElement("div");
                            recipeItem.classList.add("recipe-container");
                            recipeItem.innerHTML = `
                                <h2>${recipe.label}</h2>
                                <img class="recipe-image" src="${recipe.image}" alt="${recipe.label}">
                                <div>
                                    <p><strong>Preparation Time:</strong> ${defaultPreparationTime} minutes</p>
                                    <p><strong>Ingredients:</strong></p>
                                    <ul>
                                        ${recipe.ingredientLines.map(ingredient => `<li>${ingredient}</li>`).join('')}
                                    </ul>
                                    <p><strong>Instructions:</strong></p>
                                    ${recipe.instructions ? `<ol>${recipe.instructions.map(instruction => `<li>${instruction}</li>`).join('')}</ol>` : `<p><a href="${recipe.url}" target="_blank">Click here to see instructions</a></p>`}
                                </div>
                            `;
                            recipeList.appendChild(recipeItem);
                        });
                    });
            } else {
                console.error('Failed to translate ingredients');
            }
        });
});
