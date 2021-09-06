<?php namespace Otto\Article\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoArticle5 extends Migration
{
    public function up()
    {
        Schema::table('otto_article_', function($table)
        {
            $table->integer('is_published')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('otto_article_', function($table)
        {
            $table->dropColumn('is_published');
        });
    }
}
