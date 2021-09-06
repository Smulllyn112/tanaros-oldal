<?php namespace Otto\Contact\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoContact extends Migration
{
    public function up()
    {
        Schema::create('otto_contact_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 255)->nullable();
            $table->string('email', 255);
            $table->string('subject', 255)->nullable();
            $table->text('message')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_contact_');
    }
}
