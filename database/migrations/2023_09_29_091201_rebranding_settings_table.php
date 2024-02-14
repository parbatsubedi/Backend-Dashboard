<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RebrandingSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rebranding_setting', function (Blueprint $table){
            $table->id();
            $table->string('site_title')->nullable();
            $table->string('logo')->nullable();
            $table->string('smtp_email')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('button_text_color')->nullable();
            $table->string('hover_color')->nullable();
            $table->string('global_text_color')->nullable();
            $table->string('favicon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
