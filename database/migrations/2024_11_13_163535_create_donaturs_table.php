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
        Schema::create('donaturs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // untuk desain donatur tidak di berikan fitur login agar memudahkan
            $table->string('phone_number');// untuk menghubungi
            $table->foreignId('fundraising_id')->constrained('fundraisings')->onDelete('cascade'); //unsignedBigInteger untuk mencegah nominalnya tidak bisa (-) misal -1 
            $table->unsignedBigInteger('total_amount');
            $table->string('notes');
            $table->string('proof');
            $table->boolean('is_paid'); //is_paid untuk mengecek apakah dananya sudah masuk apa belum jika belum false jika sudah true
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donaturs');
    }
};
