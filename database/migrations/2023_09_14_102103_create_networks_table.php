<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('url');
            $table->string('type');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('group_name')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->index('user_id', 'network_user_idx');

            $table->index('group_id', 'network_group_idx');

            $table->foreign('user_id', 'network_user_fk')->on('users')->references('id');
            
            $table->integer('max_post')->nullable();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('networks');
    }
};
