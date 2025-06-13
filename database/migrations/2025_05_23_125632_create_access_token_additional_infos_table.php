<?php

declare(strict_types=1);

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
        Schema::create('access_token_additional_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('access_token_id')->constrained('personal_access_tokens')->cascadeOnDelete();
            $table->foreignIdFor(App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->integer('last_activity')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passport_access_token_additional_infos');
    }
};
