<?php namespace Otto\Article\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoArticle2 extends Migration
{
    public function up()
    {
        Schema::table('otto_article_', function($table)
        {
            $table->integer('creator_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('otto_article_', function($table)
        {
            $table->dropColumn('creator_id');
        });
    }
}
