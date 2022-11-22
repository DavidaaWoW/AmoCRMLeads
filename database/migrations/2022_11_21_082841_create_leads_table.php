<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price');
            $table->string('status', 255);
            $table->integer('responsibleUserId');
            $table->integer('createdBy');
            $table->integer('updatedBy');
            $table->integer('pipelineId');
            $table->integer('companyId')->nullable();
            $table->string('createdAt', 255);
            $table->string('updatedAt', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
};
