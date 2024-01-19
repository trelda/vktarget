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
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('url');
            $table->string('type')->nullable();
            $table->unsignedBigInteger('follower_id')->nullable();
            $table->unsignedBigInteger('friends')->nullable();
            $table->unsignedBigInteger('followers')->nullable();
            $table->string('follower_name')->nullable();
            $table->string('follower_job')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->index('user_id', 'follower_user_idx');

            $table->index('follower_id', 'follower_follower_idx');

            $table->foreign('user_id', 'follower_user_fk')->on('users')->references('id');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
