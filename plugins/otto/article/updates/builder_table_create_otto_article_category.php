<?php namespace Otto\Article\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoArticleCategory extends Migration
{
    public function up()
    {
        Schema::create('otto_article_category', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->integer('sort_number')->nullable();
            $table->text('description')->nullable();
            $table->string('slug');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_article_category');
    }
}
