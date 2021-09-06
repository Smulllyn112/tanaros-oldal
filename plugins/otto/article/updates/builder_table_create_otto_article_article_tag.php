<?php namespace Otto\Article\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoArticleArticleTag extends Migration
{
    public function up()
    {
        Schema::create('otto_article_article_tag', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('article_id')->unsigned();
            $table->integer('tag_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_article_article_tag');
    }
}
