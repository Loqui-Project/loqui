<?php

use App\Enums\UserStatusEnum;
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
        Schema::table('users', function (Blueprint $table) {
            $table->after('email', function (Blueprint $table) {
                $table->string('username')->unique()->nullable();
                $table->string('image_url')->nullable();
                $table->enum('status', array_column(UserStatusEnum::cases(), 'value'))->default(UserStatusEnum::ENABLED);
                $table->longText('bio')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('image_url');
            $table->dropColumn('status');
            $table->dropColumn('bio');
        });
    }
};
