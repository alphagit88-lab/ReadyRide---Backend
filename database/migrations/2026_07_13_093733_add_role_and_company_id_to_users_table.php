<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('driver'); // admin, company, driver
            $table->unsignedBigInteger('company_id')->nullable();
            
            $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Update default admin role
        DB::table('users')->where('email', 'admin@email.com')->update(['role' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn(['role', 'company_id']);
        });
    }
};
