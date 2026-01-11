<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('owners', function (Blueprint $table) {

            // 1. Drop foreign key first
            if (Schema::hasColumn('owners', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            // 2. Make id a foreign key
            $table->foreign('id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
   public function down() {
        Schema::table('owners', function (Blueprint $table) {

            // Recreate user_id if rolled back
            $table->foreignId('user_id')->constrained('users');

            // Remove FK on id
            $table->dropForeign(['id']);
        });
    }
};
