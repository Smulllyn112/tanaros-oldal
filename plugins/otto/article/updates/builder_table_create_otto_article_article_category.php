<?php namespace Otto\Article\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoArticleArticleCategory extends Migration
{
    public function up()
    {
        Schema::create('otto_article_article_category', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('article_id')->unsigned();
            $table->integer('category_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_article_article_category');
    }
}
