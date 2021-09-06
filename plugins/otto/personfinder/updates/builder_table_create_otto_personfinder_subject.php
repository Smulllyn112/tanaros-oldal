<?php namespace Otto\Personfinder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoPersonfinderSubject extends Migration
{
    public function up()
    {
        Schema::create('otto_personfinder_subject', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_number')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_personfinder_subject');
    }
}
