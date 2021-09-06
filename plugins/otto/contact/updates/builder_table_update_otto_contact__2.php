<?php namespace Otto\Contact\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoContact2 extends Migration
{
    public function up()
    {
        Schema::table('otto_contact_', function($table)
        {
            $table->string('phone')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('otto_contact_', function($table)
        {
            $table->dropColumn('phone');
        });
    }
}
