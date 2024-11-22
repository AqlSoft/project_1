<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_settings', function (Blueprint $table) {
            $table->id();
            
            $table->string('Name', 255)->unique();
            $table->string('Icon', 255);
            $table->string('Code', 255);
            $table->boolean('Status')->default(1);
            $table->string('GeneralAlert', 255);
            $table->string('Address', 255);
            $table->string('Phone', 20);

            $table->bigInteger('CreatedBy');
            $table->bigInteger('UpdatedBy');
        
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
        Schema::dropIfExists('dashboard_settings');
    }
}
