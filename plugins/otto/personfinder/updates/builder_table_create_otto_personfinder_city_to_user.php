<?php namespace Otto\Personfinder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoPersonfinderCityToUser extends Migration
{
    public function up()
    {
        Schema::create('otto_personfinder_city_to_user', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
            $table->integer('city_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_personfinder_city_to_user');
    }
}
