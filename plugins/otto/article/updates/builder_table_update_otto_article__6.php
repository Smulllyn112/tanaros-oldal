<?php namespace Otto\Article\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoArticle6 extends Migration
{
    public function up()
    {
        Schema::table('otto_article_', function($table)
        {
            $table->text('excerpt')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('otto_article_', function($table)
        {
            $table->string('excerpt', 191)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
