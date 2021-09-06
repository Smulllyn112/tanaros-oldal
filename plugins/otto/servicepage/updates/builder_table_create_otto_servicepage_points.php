<?php namespace Otto\Servicepage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoServicepagePoints extends Migration
{
    public function up()
    {
        Schema::create('otto_servicepage_points', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('sub_description')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_servicepage_points');
    }
}
