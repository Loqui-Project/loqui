<?php

declare(strict_types=1);

use App\Enums\NotificationType;
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
        Schema::table('notification_settings', function (Blueprint $table) {
            $table->after('key', function ($table) {
                $table->enum('type', array_column(NotificationType::cases(), 'value'));
            });
        });
    }
};
