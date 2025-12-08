<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeamLeaderNameToEventDuty extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            Schema::connection('duty')->table('Event_Duty', function (Blueprint $table) {
                if (!Schema::connection('duty')->hasColumn('Event_Duty', 'team_leader_name')) {
                    $table->string('team_leader_name')->nullable();
                }
            });
        } catch (\Exception $e) {
            \Log::error('Migration failed: ' . $e->getMessage());
            // If table doesn't exist, try to find it with proper case
            try {
                Schema::connection('duty')->table('event_duty', function (Blueprint $table) {
                    if (!Schema::connection('duty')->hasColumn('event_duty', 'team_leader_name')) {
                        $table->string('team_leader_name')->nullable();
                    }
                });
            } catch (\Exception $e2) {
                \Log::error('Fallback migration failed: ' . $e2->getMessage());
                // Let it fail if both attempts fail
                throw $e2;
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::connection('duty')->table('Event_Duty', function (Blueprint $table) {
                $table->dropColumn('team_leader_name');
            });
        } catch (\Exception $e) {
            // Try lowercase if uppercase fails
            Schema::connection('duty')->table('event_duty', function (Blueprint $table) {
                $table->dropColumn('team_leader_name');
            });
        }
    }
}