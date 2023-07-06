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
        Schema::table('users', function (Blueprint $table) {
            $table->string('lastName');
            $table->char('gender', 20);
            $table->timestamp('dob')->nullable();
            $table->boolean('isBlocked');
            $table->boolean('isActive');
            $table->string('profileImage', 100);
            $table->string('address',510);
            $table->bigInteger('contactNo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('lastName');
            $table->dropColumn('gender');
            $table->dropColumn('dob');
            $table->dropColumn('isBlocked');
            $table->dropColumn('isActive');
            $table->dropColumn('profileImage');
            $table->dropColumn('address');
            $table->dropColumn('contactNo');
        });
    }
};
