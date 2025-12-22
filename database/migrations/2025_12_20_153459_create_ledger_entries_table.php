<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transaction_id')->nullable()->index(); // links to transactions.id (if any)
            $table->foreignId('account_id')->constrained('accounts')->cascadeOnDelete();
            $table->enum('entry_type', ['debit','credit']); // debit decreases/increases depending on account nature
            $table->decimal('amount', 20, 4);
            $table->string('currency', 3)->default('USD');
            $table->string('narration')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('ledger_entries');
    }
};
