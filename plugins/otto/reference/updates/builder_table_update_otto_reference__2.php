<?php namespace Otto\Reference\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoReference2 extends Migration
{
    public function up()
    {
        Schema::table('otto_reference_', function($table)
        {
            $table->dropColumn('attributes');
        });
    }
    
    public function down()
    {
        Schema::table('otto_reference_', function($table)
        {
            $table->text('attributes')->nullable();
        });
    }
}
