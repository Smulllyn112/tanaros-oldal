<?php namespace Otto\Article\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoArticle extends Migration
{
    public function up()
    {
        Schema::table('otto_article_', function($table)
        {
            $table->integer('sort_number')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('otto_article_', function($table)
        {
            $table->integer('sort_number')->unsigned()->change();
        });
    }
}
