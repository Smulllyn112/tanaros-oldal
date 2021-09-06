<?php namespace Otto\Reference\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteOttoReferenceReferenceAttribute extends Migration
{
    public function up()
    {
        Schema::dropIfExists('otto_reference_reference_attribute');
    }
    
    public function down()
    {
        Schema::create('otto_reference_reference_attribute', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('reference_id');
            $table->integer('attribute_id');
        });
    }
}
