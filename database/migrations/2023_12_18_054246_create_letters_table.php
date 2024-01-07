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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('letter_type_id');
            $table->string('letter_perihal');
            $table->json('recipients');
            $table->text('content');
            $table->string('attachment')->nullable();
            $table->unsignedBigInteger('notulis');
            $table->timestamps();

            $table->foreign('letter_type_id')->references('id')->on('letter_types');
            $table->foreign('notulis')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
