<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Document;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, modify the status column to include 'view_only'
        Schema::table('documents', function (Blueprint $table) {
            // Drop the existing enum constraint
            $table->string('status')->change();
        });

        // Update existing information-only documents to 'view_only' status
        Document::where('requires_signature', false)
            ->where('status', 'pending')
            ->update(['status' => 'view_only']);

        // Re-add the enum constraint with the new status
        Schema::table('documents', function (Blueprint $table) {
            DB::statement("ALTER TABLE documents MODIFY COLUMN status ENUM('pending', 'signed', 'approved', 'rejected', 'view_only') DEFAULT 'pending'");
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Drop the enum constraint
            $table->string('status')->change();
        });

        // Revert view_only documents back to pending
        Document::where('status', 'view_only')
            ->update(['status' => 'pending']);

        // Re-add the original enum constraint
        Schema::table('documents', function (Blueprint $table) {
            DB::statement("ALTER TABLE documents MODIFY COLUMN status ENUM('pending', 'signed', 'approved', 'rejected') DEFAULT 'pending'");
        });
    }
}; 