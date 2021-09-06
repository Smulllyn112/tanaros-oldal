<?php namespace Otto\Servicepage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoServicepageServicepagePoints extends Migration
{
    public function up()
    {
        Schema::create('otto_servicepage_servicepage_points', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('servicepage_id')->unsigned();
            $table->integer('point_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_servicepage_servicepage_points');
    }
}
