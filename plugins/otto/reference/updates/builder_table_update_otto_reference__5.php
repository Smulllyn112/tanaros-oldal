<?php namespace Otto\Reference\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoReference5 extends Migration
{
    public function up()
    {
        Schema::table('otto_reference_', function($table)
        {
            $table->dropColumn('type');
        });
    }
    
    public function down()
    {
        Schema::table('otto_reference_', function($table)
        {
            $table->string('type', 191)->nullable()->default('website');
        });
    }
}
