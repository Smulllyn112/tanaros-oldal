<?php namespace Otto\Servicepage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoServicepage2 extends Migration
{
    public function up()
    {
        Schema::table('otto_servicepage_', function($table)
        {
            $table->dropColumn('points');
        });
    }
    
    public function down()
    {
        Schema::table('otto_servicepage_', function($table)
        {
            $table->text('points')->nullable();
        });
    }
}
