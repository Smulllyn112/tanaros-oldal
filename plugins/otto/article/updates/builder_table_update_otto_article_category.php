<?php namespace Otto\Article\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOttoArticleCategory extends Migration
{
    public function up()
    {
        Schema::table('otto_article_category', function($table)
        {
            $table->string('meta_title');
            $table->string('meta_description');
            $table->integer('sort_number')->default(null)->change();
            $table->text('description')->default(null)->change();
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
    
    public function down()
    {
        Schema::table('otto_article_category', function($table)
        {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
            $table->integer('sort_number')->default(NULL)->change();
            $table->text('description')->default('NULL')->change();
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
        });
    }
}
