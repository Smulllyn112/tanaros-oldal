<?php namespace Otto\Contact\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoContactStatic extends Migration
{
    public function up()
    {
        Schema::create('otto_contact_static', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('content')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_contact_static');
    }
}
