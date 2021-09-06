<?php namespace Otto\Reference\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoReferenceReferenceCategory extends Migration
{
    public function up()
    {
        Schema::table('otto_reference_reference_category', function($table)
        {
            $table->renameColumn('reference_category_id', 'category_id');
        });
    }
    
    public function down()
    {
        Schema::table('otto_reference_reference_category', function($table)
        {
            $table->renameColumn('category_id', 'reference_category_id');
        });
    }
}
