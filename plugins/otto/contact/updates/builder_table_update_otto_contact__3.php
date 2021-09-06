<?php namespace Otto\Contact\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoContact3 extends Migration
{
    public function up()
    {
        Schema::table('otto_contact_', function($table)
        {
            $table->string('email', 255)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('otto_contact_', function($table)
        {
            $table->string('email', 255)->nullable(false)->change();
        });
    }
}
