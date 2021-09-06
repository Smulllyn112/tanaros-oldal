<?php namespace Otto\Servicepage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoServicepage3 extends Migration
{
    public function up()
    {
        Schema::table('otto_servicepage_', function($table)
        {
            $table->string('section_title_fat')->nullable();
            $table->text('section_sub_description')->nullable();
            $table->string('section_rat_title_fat')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('otto_servicepage_', function($table)
        {
            $table->dropColumn('section_title_fat');
            $table->dropColumn('section_sub_description');
            $table->dropColumn('section_rat_title_fat');
        });
    }
}
