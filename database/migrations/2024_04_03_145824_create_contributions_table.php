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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contributor_id')->constrained();
            $table->foreignId('cycle_id')->constrained();
            $table->string('platform')->nullable();
            $table->text('url')->nullable();
            $table->string('type')->nullable();
            $table->integer('level')->nullable();
            $table->decimal('percentage', 10, 2)->nullable();
            $table->decimal('reward')->nullable();
            $table->string('comment')->nullable();
            $table->boolean('confirmed')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
