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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('members')->nullable();
            $table->timestamp('date')->useCurrent();
            
            $table->unsignedBigInteger('group_id')->nullable();
            $table->index('group_id', 'members_group_idx');

            $table->foreign('group_id', 'member_group_fk')->on('networks')->references('group_id');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
