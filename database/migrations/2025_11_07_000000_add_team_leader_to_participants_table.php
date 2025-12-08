<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The database connection for this migration.
     *
     * @var string
     */
    public $connection = 'duty';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add a team_leader boolean to Participants if it doesn't exist
        try {
            Schema::connection($this->connection)->table('Participants', function (Blueprint $table) {
                if (!Schema::connection('duty')->hasColumn('Participants', 'team_leader')) {
                    $table->boolean('team_leader')->default(false)->after('email');
                }
            });
        } catch (\Exception $e) {
            // Log and continue — some environments may not have the duty DB available during migration
            \Log::warning('Could not add team_leader to Participants: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::connection($this->connection)->table('Participants', function (Blueprint $table) {
                if (Schema::connection('duty')->hasColumn('Participants', 'team_leader')) {
                    $table->dropColumn('team_leader');
                }
            });
        } catch (\Exception $e) {
            \Log::warning('Could not drop team_leader from Participants: ' . $e->getMessage());
        }
    }
};
