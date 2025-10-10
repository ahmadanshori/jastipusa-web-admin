<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Add indexes to improve query performance for DataTables
     */
    public function up(): void
    {
        Schema::table('purchase_order', function (Blueprint $table) {
            // Index for sorting by updated_at (used in latest('updated_at'))
            $table->index('updated_at');

            // Index for created_at (used in date formatting)
            $table->index('created_at');

            // Index for no_invoice (used in display and search)
            $table->index('no_invoice');

            // Index for status (used in filtering)
            $table->index('status');

            // Composite index for common query patterns
            $table->index(['updated_at', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_order', function (Blueprint $table) {
            $table->dropIndex(['updated_at']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['no_invoice']);
            $table->dropIndex(['status']);
            $table->dropIndex(['updated_at', 'status']);
        });
    }
};
