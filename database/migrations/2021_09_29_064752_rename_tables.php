<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('actor', 'actors');
        Schema::rename('address', 'addresses');
        Schema::rename('category', 'categores');
        Schema::rename('city', 'cities');
        Schema::rename('country', 'countries');
        Schema::rename('customer', 'customers');
        Schema::rename('film', 'films');
        Schema::rename('film_actor', 'film_actors');
        Schema::rename('film_category', 'film_categories');
        Schema::rename('film_text', 'film_texts');
        Schema::rename('inventory', 'inventories');
        Schema::rename('language', 'languages');
        Schema::rename('payment', 'payments');
        Schema::rename('rental', 'rentals');
        Schema::rename('staff', 'staffs');
        Schema::rename('store', 'stores');        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
