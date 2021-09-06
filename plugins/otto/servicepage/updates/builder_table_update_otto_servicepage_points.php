<?php namespace Otto\Servicepage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoServicepagePoints extends Migration
{
    public function up()
    {
        Schema::table('otto_servicepage_points', function($table)
        {
            $table->integer('sort_number')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('otto_servicepage_points', function($table)
        {
            $table->dropColumn('sort_number');
        });
    }
}
