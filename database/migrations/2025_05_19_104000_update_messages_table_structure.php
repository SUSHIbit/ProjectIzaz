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
        Schema::table('messages', function (Blueprint $table) {
            // Drop existing columns if they exist
            if (Schema::hasColumn('messages', 'sender_id')) {
                $table->dropForeign(['sender_id']);
                $table->dropColumn('sender_id');
            }
            if (Schema::hasColumn('messages', 'receiver_id')) {
                $table->dropForeign(['receiver_id']);
                $table->dropColumn('receiver_id');
            }
            if (Schema::hasColumn('messages', 'content')) {
                $table->dropColumn('content');
            }
            if (Schema::hasColumn('messages', 'read_at')) {
                $table->dropColumn('read_at');
            }

            // Add new columns if they don't exist
            if (!Schema::hasColumn('messages', 'sender_role')) {
                $table->string('sender_role');
            }
            if (!Schema::hasColumn('messages', 'message')) {
                $table->text('message');
            }
            if (!Schema::hasColumn('messages', 'is_read')) {
                $table->boolean('is_read')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Drop new columns if they exist
            if (Schema::hasColumn('messages', 'sender_role')) {
                $table->dropColumn('sender_role');
            }
            if (Schema::hasColumn('messages', 'message')) {
                $table->dropColumn('message');
            }
            if (Schema::hasColumn('messages', 'is_read')) {
                $table->dropColumn('is_read');
            }

            // Add back original columns if they don't exist
            if (!Schema::hasColumn('messages', 'sender_id')) {
                $table->foreignId('sender_id')->after('id')->constrained('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('messages', 'receiver_id')) {
                $table->foreignId('receiver_id')->after('sender_id')->constrained('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('messages', 'content')) {
                $table->text('content');
            }
            if (!Schema::hasColumn('messages', 'read_at')) {
                $table->timestamp('read_at')->nullable();
            }
        });
    }
}; 