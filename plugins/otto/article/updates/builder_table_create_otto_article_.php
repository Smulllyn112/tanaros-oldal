<?php namespace Otto\Article\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoArticle extends Migration
{
    public function up()
    {
        Schema::create('otto_article_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->integer('sort_number')->nullable()->unsigned();
            $table->text('description')->nullable();
            $table->string('excerpt')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_article_');
    }
}
