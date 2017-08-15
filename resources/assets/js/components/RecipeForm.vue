<style scoped>
    .recipe-list {
        position: relative;
        margin-top: 1.5rem;
        background-color: #FFFFFF;
        border: 1px solid #E9E9E9;
    }

    .recipe-list__item {
        padding: 10px 0 4px 90px;
        border-bottom: 1px solid #E9E9E9;
    }

    .recipe-list__item:last-child {
        border-bottom: none;
    }

    .recipe-list__item:before,
    .recipe-list__item:after {
        content: "";
        position: absolute;
        top: 0;
        height: 100%;
        width: 1px;
        background-color: #FFD4D4;
    }

    .recipe-list__item:before {
        left: 70px;
    }

    .recipe-list__item:after {
        left: 75px;
    }

    .section-header {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: 700;
    }
</style>

<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8 col-xs-12">
                <form @submit.prevent="saveRecipe()">
                    <div class="card card--top-border" :class="{'card--disabled': saving}">
                        <div class="form-group">
                            <label for="recipe-name" class="required">Name</label>
                            <input id="recipe-name" type="text"
                                   class="form-control" name="name"
                                   placeholder="Chicken Tikka Masala"
                                   v-model="recipeName"
                            />
                        </div>
                    </div>

<<<<<<< 0b8b39ad84a931b924760d139d2094c4ca01a92c
                            <div class="tab-content">
                                <section role="tabpanel" class="tab-pane active" id="ingredients">
                                    <h3>Ingredients</h3>
                                    <div>
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Quantity</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="ingredient in recipeIngredients">
                                                <td>
                                                    <input type="text" v-model="ingredient.name" placeholder="Chicken"/>
                                                </td>
                                                <td>
                                                    <input type="text" v-model="ingredient.quantity" placeholder="500"/>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                                <section role="tabpanel" class="tab-pane" id="method">
=======
                    <div class="card card--top-border" :class="{'card--disabled': saving}">
                        <section>
                            <header class="section-header">
                                Ingredients
                            </header>
                            <div>
                                <ul class="list-unstyled recipe-list">
                                    <li v-for="recipeIngredient in recipeIngredients" class="recipe-list__item">
                                        <p>
                                            {{ recipeIngredient.ingredient.name }} -
                                            {{ recipeIngredient.quantity + recipeIngredient.ingredient.unitOfMeasurement
                                            }}
                                        </p>
                                    </li>
                                    <li class="recipe-list__item">
                                        <form @submit.prevent="addRecipeIngredient()" class="form-inline">
                                            <select class="form-control" title="Ingredient selection"
                                                    v-model="nextIngredient.id">
                                                <option disabled :value="null">Please select an ingredient</option>
                                                <option v-for="ingredient in ingredients" :value="ingredient.id">
                                                    {{ ingredient.name }}
                                                </option>
                                            </select>
                                            <input type="number" class="form-control" title="Ingredient quantity"
                                                   v-model="nextIngredient.quantity"/>
                                            <button class="btn btn-primary" type="submit">
                                                Add
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </section>
                    </div>
>>>>>>> Finished the rough version of the create recipe form

                    <div class="card card--top-border" :class="{'card--disabled': saving}">
                        <section>
                            <header class="section-header">
                                Method
                            </header>
                            <div>
                                <ol>
                                    <li v-for="instruction in recipeInstructions">
                                        <p>{{ instruction.description }}</p>
                                    </li>
                                    <li>
                                        <form @submit.prevent="addInstruction()" class="form-inline">
                                            <input type="text" class="form-control" title="Instruction"
                                                   v-model="nextInstruction"/>
                                            <button class="btn btn-primary" type="submit">
                                                Add
                                            </button>
                                        </form>
                                    </li>
                                </ol>
                            </div>
                        </section>
                    </div>

                    <div class="card card--top-border clearfix">
                        <div class="pull-right">
                            <button class="btn btn-success" type="submit" :disabled="!canSaveRecipe">
                                Save recipe
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
<<<<<<< 0b8b39ad84a931b924760d139d2094c4ca01a92c
                recipeIngredients: [{
                    name: 'Chicken',
                    quantity: '500',
                }],
                recipeInstructions: [],
                ingredients: [],
            };
        },
=======
                recipeName: null,
                recipeIngredients: [],
                recipeInstructions: [],
                nextIngredient: {
                    id: null,
                    quantity: null,
                },
                nextInstruction: null,
                saving: false,
            };
        },
        computed: {
            canSaveRecipe: function () {
                return this.recipeName !== null &&
                    this.recipeIngredients.length > 0 &&
                    this.recipeInstructions.length > 0 &&
                    !this.saving;
            },
        },
        methods: {
            addRecipeIngredient: function () {
                const {id, quantity} = this.nextIngredient;

                if (id !== null && quantity !== null) {
                    let ingredient = this.ingredients.filter(ingredient => ingredient.id === id);
                    ingredient = ingredient.length === 1 ? ingredient[0] : null;

                    if (!ingredient) {
                        return;
                    }

                    this.recipeIngredients.push({ingredient, quantity});
                    this.resetNextIngredient();
                }
            },
            resetNextIngredient: function () {
                this.nextIngredient = {
                    id: null,
                    quantity: null
                };
            },
            addInstruction: function () {
                if (this.nextInstruction !== null && this.nextInstruction.trim().length > 0) {
                    this.recipeInstructions.push({
                        description: this.nextInstruction,
                    });
                    this.nextInstruction = null;
                }
            },
            saveRecipe: function () {
                if (this.canSaveRecipe) {
                    this.saving = true;
                    axios.post("/recipes", {
                        name: this.recipeName,
                        ingredients: this.recipeIngredients.map(recipeIngredient => ({
                            id: recipeIngredient.ingredient.id,
                            quantity: recipeIngredient.quantity,
                        })),
                        instructions: this.recipeInstructions,
                    }).then((res) => {
                        this.saving = false;
                        window.location = `/recipes/${res.data.recipe.id}`;
                    }).catch((err) => {
                        this.saving = false;
                    });
                }
            },
        },
>>>>>>> Finished the rough version of the create recipe form
    }
</script>
