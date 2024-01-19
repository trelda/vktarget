<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *   'group_id'
     *   'post_id'
     *   'ads'
     *   'caption'
     *   'date'
     *   'text'
     *   'views'
     *   'likes'
     *   'reposts'
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            $table->unsignedBigInteger('group_id')->nullable();
            $table->index('group_id', 'posts_group_idx');
            $table->foreign('group_id', 'post_group_fk')->on('networks')->references('group_id');

            $table->unsignedBigInteger('post_id')->nullable();

            $table->boolean('ads')->default(false);

            $table->longText('caption')->nullable();

            $table->timestamp('date')->useCurrent();

            $table->longText('text')->nullable();

            $table->integer('views')->nullable();

            $table->integer('likes')->nullable();

            $table->integer('reposts')->nullable();

            $table->boolean('is_repost')->nullable();
            
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
