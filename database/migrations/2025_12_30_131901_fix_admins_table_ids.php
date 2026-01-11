<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('admins', function (Blueprint $table) {

            if (Schema::hasColumn('admins', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            $table->foreign('id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::table('admins', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->dropForeign(['id']);
        });
    }
};
