<?php namespace Otto\Personfinder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoPersonfinderSubscriptionTransactions extends Migration
{
    public function up()
    {
        Schema::create('otto_personfinder_subscription_transactions', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('subscription_id');
            $table->string('reference');
            $table->string('simplepay_id');
            $table->string('simplepay_status');
            $table->boolean('simplepay_checked_ipn');
            $table->timestamp('created_at');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_personfinder_subscription_transactions');
    }
}
