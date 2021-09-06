<?php namespace Otto\Personfinder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoPersonfinderSubjectToUser extends Migration
{
    public function up()
    {
        Schema::table('otto_personfinder_subject_to_user', function($table)
        {
            $table->date('alap_kiemelt_until')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('otto_personfinder_subject_to_user', function($table)
        {
            $table->dropColumn('alap_kiemelt_until');
        });
    }
}
