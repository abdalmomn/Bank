<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->decimal('fixed_amount', 20, 4)->nullable();
            $table->decimal('percentage', 8, 4)->nullable(); // percent e.g. 0.5 = 0.5%
            $table->json('conditions')->nullable(); // e.g. min_amount, account_types
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
