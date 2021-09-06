<?php namespace Otto\Article\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoArticle4 extends Migration
{
    public function up()
    {
        Schema::table('otto_article_', function($table)
        {
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('otto_article_', function($table)
        {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });
    }
}
