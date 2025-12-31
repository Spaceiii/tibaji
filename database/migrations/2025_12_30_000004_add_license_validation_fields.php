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
        Schema::table('licenses', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('level');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('file_path');
            $table->timestamp('submitted_at')->nullable()->after('status');
            $table->timestamp('verified_at')->nullable()->after('submitted_at');
            $table->text('admin_comment')->nullable()->after('verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->dropColumn([
                'file_path',
                'status',
                'submitted_at',
                'verified_at',
                'admin_comment'
            ]);
        });
    }
};
