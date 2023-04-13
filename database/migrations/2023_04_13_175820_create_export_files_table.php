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
        Schema::create('export_files', function (Blueprint $table) {
            $table->id();
            $table->integer('entity_type')->index()->comment('1:Users, 2:Roles, 3:Skills');
            $table->string('filename');
            $table->string('filepath');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('created_at');
            $table->unsignedInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_files');
    }
};
