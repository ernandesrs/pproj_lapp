<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_senders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('setting_id')->constrained('settings', 'id')->cascadeOnDelete();

            $table->string('display_name', 20)->unique();
            $table->boolean('default')->default(false);
            $table->string('host');
            $table->string('port');
            $table->string('encrypt');
            $table->string('username');
            $table->string('password');
            $table->string('from_mail');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_senders');
    }
};
