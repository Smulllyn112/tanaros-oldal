<?php namespace Otto\Servicepage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoServicepageServicepagePoints extends Migration
{
    public function up()
    {
        Schema::table('otto_servicepage_servicepage_points', function($table)
        {
            $table->renameColumn('servicepage_id', 'service_page_id');
        });
    }
    
    public function down()
    {
        Schema::table('otto_servicepage_servicepage_points', function($table)
        {
            $table->renameColumn('service_page_id', 'servicepage_id');
        });
    }
}
