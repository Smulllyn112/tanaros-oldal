<?php namespace Otto\Servicepage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoServicepage extends Migration
{
    public function up()
    {
        Schema::table('otto_servicepage_', function($table)
        {
            $table->string('type')->default('service_page');
        });
    }
    
    public function down()
    {
        Schema::table('otto_servicepage_', function($table)
        {
            $table->dropColumn('type');
        });
    }
}
