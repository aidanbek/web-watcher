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
        Schema::create('dump_diffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_old_dump_id');
            $table->foreignId('page_new_dump_id');
            $table->foreignId('diff_type_id');
            $table->text('html')->nullable();
            $table->text('json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dump_diffs');
    }
};
