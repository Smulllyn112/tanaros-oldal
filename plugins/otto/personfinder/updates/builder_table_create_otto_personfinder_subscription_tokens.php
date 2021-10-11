<?php namespace Otto\Personfinder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoPersonfinderSubscriptionTokens extends Migration
{
    public function up()
    {
        Schema::create('otto_personfinder_subscription_tokens', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('subscription_id');
            $table->string('simplepay_token');
            $table->string('simplepay_transaction_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_personfinder_subscription_tokens');
    }
}
