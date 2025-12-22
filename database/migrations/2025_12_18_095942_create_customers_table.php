<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Personal details (from front)
            $table->string('first_name');
            $table->string('father_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('national_id')->nullable()->index();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('nationality')->nullable();
            $table->string('mother_name')->nullable();
            $table->integer('age')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('occupation')->nullable();
            $table->string('education_level')->nullable();

            // Financial
            $table->decimal('monthly_income', 18, 2)->nullable();
            $table->decimal('monthly_expenses', 18, 2)->nullable();

            $table->enum('kyc_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
