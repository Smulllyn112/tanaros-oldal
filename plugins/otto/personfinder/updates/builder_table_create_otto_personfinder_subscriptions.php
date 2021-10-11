<?php namespace Otto\Personfinder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoPersonfinderSubscriptions extends Migration
{
    public function up()
    {
        Schema::create('otto_personfinder_subscriptions', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('reference');
            $table->integer('user_id');
            $table->float('amount');
            $table->integer('recurring_cycle');
            $table->string('recurring_cycle_metric');
            $table->date('recurring_start');
            $table->date('recurring_final_payment_date');
            $table->date('recurring_next_billing_date');
            $table->date('recurring_last_payment_date');
            $table->string('recurring_state');
            $table->integer('status_id');
            $table->integer('invoice_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_personfinder_subscriptions');
    }
}
