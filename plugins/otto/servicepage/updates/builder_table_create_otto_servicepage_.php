<?php namespace Otto\Servicepage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoServicepage extends Migration
{
    public function up()
    {
        Schema::create('otto_servicepage_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->string('section_title')->nullable();
            $table->text('section_description')->nullable();
            $table->text('points')->nullable();
            $table->string('rat_title')->nullable();
            $table->text('rat_description')->nullable();
            $table->integer('sort_number')->nullable();
            $table->string('slug');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_servicepage_');
    }
}
