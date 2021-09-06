<?php namespace Otto\Contact\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoContactTakeOffer extends Migration
{
    public function up()
    {
        Schema::create('otto_contact_take_offer_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('needed_items')->nullable();
            $table->string('preference')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->nullable();
            $table->integer('sort_number')->nullable();
            $table->text('notices')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_contact_take_offer_');
    }
}
