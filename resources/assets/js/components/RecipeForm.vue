<template>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8 col-xs-12">
                <form>
                    <div class="card card--top-border">
                        <div class="form-group">
                            <label for="recipe-name" class="required">Name</label>
                            <input id="recipe-name" type="text"
                                   class="form-control" name="name"
                                   placeholder="Chicken Tikka Masala"
                            />
                        </div>
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#ingredients" aria-controls="home" role="tab" data-toggle="tab">
                                        Ingredients
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#method" aria-controls="profile" role="tab" data-toggle="tab">
                                        Method
                                    </a>
                                </li>
                            </ul>

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

                                </section>
                            </div>
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
                recipeIngredients: [{
                    name: 'Chicken',
                    quantity: '500',
                }],
                recipeInstructions: [],
                ingredients: [],
            };
        },
    }
</script>
