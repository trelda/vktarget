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
        Schema::create('lom_posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('lom_id')->nullable();
            $table->string('lom_name')->nullable();
            $table->string('post_link')->nullable();
            $table->string('post_type')->nullable();
            $table->string('post_prism')->nullable();
            $table->dateTime('post_date');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lom_posts');
    }
};
