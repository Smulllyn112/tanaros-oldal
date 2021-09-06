<?php namespace Otto\Servicepage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoServicepagePoints2 extends Migration
{
    public function up()
    {
        Schema::table('otto_servicepage_points', function($table)
        {
            $table->string('fat_title')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('otto_servicepage_points', function($table)
        {
            $table->dropColumn('fat_title');
        });
    }
}
