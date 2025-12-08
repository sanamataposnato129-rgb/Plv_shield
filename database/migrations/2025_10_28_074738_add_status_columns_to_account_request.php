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
        Schema::table('Account_Request', function (Blueprint $table) {
            // Add status and review columns if they don't already exist (for preexisting DBs)
            if (! Schema::hasColumn('Account_Request', 'request_status')) {
                $table->enum('request_status', ['Pending', 'Approved', 'Rejected'])->default('Pending')->after('password_hash');
            }

            if (! Schema::hasColumn('Account_Request', 'reviewed_by')) {
                $table->unsignedBigInteger('reviewed_by')->nullable()->after('request_status');
            }

            if (! Schema::hasColumn('Account_Request', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Account_Request', function (Blueprint $table) {
            if (Schema::hasColumn('Account_Request', 'reviewed_at')) {
                $table->dropColumn('reviewed_at');
            }

            if (Schema::hasColumn('Account_Request', 'reviewed_by')) {
                $table->dropColumn('reviewed_by');
            }

            if (Schema::hasColumn('Account_Request', 'request_status')) {
                $table->dropColumn('request_status');
            }
        });
    }
};
