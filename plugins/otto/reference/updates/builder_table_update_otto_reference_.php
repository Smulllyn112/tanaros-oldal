<?php namespace Otto\Reference\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoReference extends Migration
{
    public function up()
    {
        Schema::table('otto_reference_', function($table)
        {
            $table->renameColumn('points', 'attributes');
        });
    }
    
    public function down()
    {
        Schema::table('otto_reference_', function($table)
        {
            $table->renameColumn('attributes', 'points');
        });
    }
}
