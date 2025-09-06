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
        // Check if table exists, if not create it with correct structure
        if (!Schema::hasTable('exchange')) {
            Schema::create('exchange', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->decimal('value', 15, 2);
                $table->timestamps();
            });
        } else {
            // If table exists, check if it has the correct columns
            Schema::table('exchange', function (Blueprint $table) {
                if (!Schema::hasColumn('exchange', 'value')) {
                    $table->decimal('value', 15, 2)->after('name');
                }

                // If there's a 'number' column, rename it to 'value'
                if (Schema::hasColumn('exchange', 'number') && !Schema::hasColumn('exchange', 'value')) {
                    $table->renameColumn('number', 'value');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange');
    }
};
