<?php namespace Otto\Servicepage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoServicepage4 extends Migration
{
    public function up()
    {
        Schema::table('otto_servicepage_', function($table)
        {
            $table->string('meta_description')->nullable();
            $table->string('meta_title')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('otto_servicepage_', function($table)
        {
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_title');
        });
    }
}
