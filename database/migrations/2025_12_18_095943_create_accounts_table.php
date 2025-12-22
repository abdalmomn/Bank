<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->unique();
            $table->foreignId('account_type_id')->constrained('account_types')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();

            $table->foreignId('parent_id')->nullable()->constrained('accounts')->cascadeOnDelete();

            $table->decimal('balance', 20, 4)->default(0); // cached balance
            $table->string('currency', 3)->default('USD');
            $table->enum('state', ['active','frozen','closed'])->default('active');

            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
