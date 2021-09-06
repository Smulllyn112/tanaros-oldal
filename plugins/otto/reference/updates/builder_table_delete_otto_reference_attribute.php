<?php namespace Otto\Reference\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteOttoReferenceAttribute extends Migration
{
    public function up()
    {
        Schema::dropIfExists('otto_reference_attribute');
    }
    
    public function down()
    {
        Schema::create('otto_reference_attribute', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 255);
        });
    }
}
