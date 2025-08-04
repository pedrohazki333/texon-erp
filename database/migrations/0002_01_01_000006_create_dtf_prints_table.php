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
        Schema::create('dtf_prints', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->date('print_date');
            $table->decimal('meters', 6, 2);
            $table->enum('status', ['pendente', 'em produção', 'impresso', 'finalizado'])->default('pendente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dtf_prints');
    }
};
