<?php namespace Otto\Reference\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoReferenceReferenceAttribute extends Migration
{
    public function up()
    {
        Schema::create('otto_reference_reference_attribute', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('reference_id');
            $table->integer('attribute_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_reference_reference_attribute');
    }
}
