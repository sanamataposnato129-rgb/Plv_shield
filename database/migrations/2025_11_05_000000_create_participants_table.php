<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This creates a Participants table on the 'duty' connection and
     * attempts to add foreign keys to Event_Duty (same DB) and Student (Accounts DB).
     *
     * Note: cross-database foreign keys require both databases to be on the same MySQL server
     * and privileges to create foreign keys across schemas. If not supported the migration
     * will still create the table without the cross-DB FK.
     */
    public function up()
    {
        // Use the 'duty' connection for the participants table
        Schema::connection('duty')->create('Participants', function (Blueprint $table) {
            $table->bigIncrements('participant_id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('plv_student_id', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->timestamps();

            // FK to Event_Duty in the duty DB
            $table->index('event_id');
        });

        // Add foreign key for event_id referencing Event_Duty(event_id)
        try {
            DB::connection('duty')->statement(
                'ALTER TABLE `Participants` ADD CONSTRAINT `fk_participants_event` FOREIGN KEY (`event_id`) REFERENCES `Event_Duty`(`event_id`) ON DELETE CASCADE'
            );
        } catch (\Exception $e) {
            // If FK creation fails, log and continue (some MySQL setups don't allow cross-schema or strict FK rules)
            \Log::warning('Could not create fk_participants_event: ' . $e->getMessage());
        }

        // Attempt to add foreign key to the Student table in the Accounts DB (default connection)
        $accountsDb = config('database.connections.mysql.database');
        if ($accountsDb) {
            try {
                // Build fully qualified table name for Student in accounts DB
                $fq = DB::connection('duty')->getDoctrineSchemaManager()->getDatabasePlatform()->getName();
            } catch (\Exception $e) {
                // ignore
            }

            try {
                $accountsDbName = $accountsDb;
                // Add FK referencing `accounts_db`.`Student`(user_id)
                DB::connection('duty')->statement(
                    "ALTER TABLE `Participants` ADD CONSTRAINT `fk_participants_student` FOREIGN KEY (`user_id`) REFERENCES `{$accountsDbName}`.`Student`(`user_id`) ON DELETE SET NULL"
                );
            } catch (\Exception $e) {
                \Log::warning('Could not create fk_participants_student (cross-db FK): ' . $e->getMessage());
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Drop table on duty connection
        Schema::connection('duty')->dropIfExists('Participants');
    }
};
