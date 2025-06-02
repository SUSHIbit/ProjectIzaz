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
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'category')) {
                $table->string('category')->nullable()->after('title');
            }
            if (!Schema::hasColumn('documents', 'document_type')) {
                $table->string('document_type')->nullable()->after('description');
            }
            if (!Schema::hasColumn('documents', 'expiry_date')) {
                $table->date('expiry_date')->nullable()->after('document_type');
            }
            if (!Schema::hasColumn('documents', 'is_required')) {
                $table->boolean('is_required')->default(false)->after('expiry_date');
            }
            if (!Schema::hasColumn('documents', 'version')) {
                $table->integer('version')->default(1)->after('is_required');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'document_type',
                'expiry_date',
                'is_required',
                'version'
            ]);
        });
    }
}; 