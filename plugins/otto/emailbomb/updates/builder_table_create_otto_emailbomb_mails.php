<?php namespace Otto\Emailbomb\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOttoEmailbombMails extends Migration
{
    public function up()
    {
        Schema::create('otto_emailbomb_mails', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_mail_sent')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otto_emailbomb_mails');
    }
}
