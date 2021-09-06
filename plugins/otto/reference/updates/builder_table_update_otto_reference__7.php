<?php namespace Otto\Reference\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoReference7 extends Migration
{
    public function up()
    {
        Schema::table('otto_reference_', function($table)
        {
            $table->string('type')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('otto_reference_', function($table)
        {
            $table->dropColumn('type');
        });
    }
}
