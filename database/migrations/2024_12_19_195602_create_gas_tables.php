<?php

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
        Schema::create('gases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->integer('total')->default(0);
            $table->timestamps();
        });


        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['in', 'out']);
            $table->foreignId('gas_id')->constrained('gases')->onDelete('cascade');
            $table->index('gas_id');
            $table->integer('qty');
            $table->decimal('amount', 10, 2);
            $table->decimal('optional_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->text('description')->nullable();
            $table->text('reference')->nullable();
            $table->date('transaction_date')->nullable();
            $table->text('attachment')->nullable();
            $table->enum('status', ['completed', 'pending', 'canceled'])->default('completed');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->index('created_by');
            $table->index('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gas_tables');
    }
};
