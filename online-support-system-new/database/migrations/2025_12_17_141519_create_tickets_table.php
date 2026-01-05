<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->string('customer_name');
            $table->string('email');
            $table->string('phone');
            $table->text('problem_description');
            $table->enum('status', ['new', 'in_progress', 'resolved'])->default('new');
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('opened_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
