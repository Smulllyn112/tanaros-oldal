<?php namespace Otto\Reference\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoReferenceAttribute extends Migration
{
    public function up()
    {
        Schema::create('otto_reference_attribute', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 255);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_reference_attribute');
    }
}
