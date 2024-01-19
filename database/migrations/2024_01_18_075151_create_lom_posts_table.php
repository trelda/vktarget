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
            $table->lom_id();
            $table->lom_name();
            $table->post_link();
            $table->post_type();
            $table->post_date();

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
