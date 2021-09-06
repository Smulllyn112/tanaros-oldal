<?php namespace Otto\Article\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoArticleCategory2 extends Migration
{
    public function up()
    {
        Schema::table('otto_article_category', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('sort_number')->nullable(false)->unsigned()->default(null)->change();
            $table->text('description')->default('null')->change();
        });
    }
    
    public function down()
    {
        Schema::table('otto_article_category', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->integer('sort_number')->nullable()->unsigned(false)->default(NULL)->change();
            $table->text('description')->default('NULL')->change();
        });
    }
}
