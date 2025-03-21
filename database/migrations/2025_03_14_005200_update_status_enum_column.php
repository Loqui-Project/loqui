<?php

declare(strict_types=1);

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
        Schema::table('users', function (Blueprint $table): void {
            $defaultValue = UserStatusEnum::ENABLED->value;
            $table->dropColumn('status');
            $table->enum('status', array_column(UserStatusEnum::cases(), 'value'))->default($defaultValue);
        });
    }
};
