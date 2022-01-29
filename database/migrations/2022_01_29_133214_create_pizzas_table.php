<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePizzasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pizzas', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('name');

            $table->integer('user_owner')->unsigned();
            $table->integer('user_log')->unsigned();

            $table->foreign('user_owner')->references('id')->on('users');
            $table->foreign('user_log')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();            
        });

        Schema::create('weight', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();    
        });

        Schema::create('pizzas_weight', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pizza_id')->unsigned();
            $table->integer('weight_id')->unsigned();            
            $table->integer('user_owner')->unsigned();
            $table->integer('user_log')->unsigned();

            $table->foreign('pizza_id')->references('id')->on('pizzas');
            $table->foreign('weight_id')->references('id')->on('weight');
            $table->foreign('user_owner')->references('id')->on('users');
            $table->foreign('user_log')->references('id')->on('users');
            
            $table->timestamps();
            $table->softDeletes();    
        });

        Schema::create('ingredients', function (Blueprint $table) {
            $table->increments('id');                       
            $table->string('name');
            $table->decimal('weight');
            $table->integer('user_owner')->unsigned();
            $table->integer('user_log')->unsigned();

            $table->foreign('user_owner')->references('id')->on('users');
            $table->foreign('user_log')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();            
        });

        Schema::create('pizza_ingredients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pizza_id')->unsigned();
            $table->integer('ingredient_id')->unsigned();
            $table->integer('quantity');
            $table->integer('user_owner')->unsigned();
            $table->integer('user_log')->unsigned();

            $table->foreign('pizza_id')->references('id')->on('pizzas');
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
            $table->foreign('user_owner')->references('id')->on('users');
            $table->foreign('user_log')->references('id')->on('users');
            
            $table->timestamps();
            $table->softDeletes();    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pizza_ingredients', function (Blueprint $table) {
            $table->dropForeign('pizza_ingredients_ingredient_id_foreign');    
            $table->dropForeign('pizza_ingredients_pizza_id_foreign');    
            $table->dropForeign('pizza_ingredients_user_log_foreign');
            $table->dropForeign('pizza_ingredients_user_owner_foreign');
        });        

        Schema::table('ingredients', function (Blueprint $table) {
            $table->dropForeign('ingredients_user_log_foreign');
            $table->dropForeign('ingredients_user_owner_foreign');
        });

        Schema::table('pizzas_weight', function (Blueprint $table) {            
            $table->dropForeign('pizzas_weight_pizza_id_foreign');
            $table->dropForeign('pizzas_weight_weight_id_foreign');
            $table->dropForeign('pizzas_weight_user_log_foreign');
            $table->dropForeign('pizzas_weight_user_owner_foreign');
        });

        Schema::table('pizzas', function (Blueprint $table) {
            $table->dropForeign('pizzas_user_log_foreign');
            $table->dropForeign('pizzas_user_owner_foreign');
        });

        Schema::dropIfExists('weight');
        Schema::dropIfExists('pizza_ingredients');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('pizzas_weight');
        Schema::dropIfExists('pizzas');
    }
}
