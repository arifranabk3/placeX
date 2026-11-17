<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->string('transaction_reference', 100)->unique();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('promotion_plan_id')->nullable()->constrained('promotion_plans')->nullOnDelete();
                $table->foreignId('listing_id')->nullable()->constrained('listings')->nullOnDelete();
                $table->decimal('amount', 12, 2);
                $table->char('currency', 3)->default('PKR');
                $table->string('payment_method', 50)->default('manual_credit'); // bank_transfer, cash, manual_credit, easypaisa, jazzcash
                $table->enum('payment_status', ['pending', 'completed', 'failed', 'refunded'])->default('completed');
                $table->text('notes')->nullable();
                $table->json('gateway_response')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'payment_status']);
                $table->index(['created_at']);
            });
        }

        if (!Schema::hasTable('system_settings')) {
            Schema::create('system_settings', function (Blueprint $table) {
                $table->id();
                $table->string('group', 50)->default('general'); // general, marketplace, listings, categories, moderation, notifications, security
                $table->string('key', 100)->unique();
                $table->text('value')->nullable();
                $table->string('type', 20)->default('string'); // string, boolean, integer, json
                $table->string('description')->nullable();
                $table->boolean('is_public')->default(false);
                $table->timestamps();

                $table->index(['group']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('system_settings');
    }
};
