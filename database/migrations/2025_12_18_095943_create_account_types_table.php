<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('account_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g. current, saving, investment, loan
            $table->string('name');
            $table->json('config')->nullable(); // interest rate, min balance, etc.
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('account_types');
    }
};
