<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create('Duty_Reports', function (Blueprint $table) {
            $table->bigIncrements('id');

            // link to the Participants table (participant records)
            $table->unsignedBigInteger('participant_id')->nullable();
            $table->unsignedBigInteger('event_id')->nullable();

            // preserve both internal user id and plv student id where available
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('plv_student_id', 50)->nullable();

            $table->string('summary', 255);
            $table->text('details');

            // JSON array holding stored attachment paths/metadata
            $table->json('attachments')->nullable();

            $table->enum('status', ['completed','incomplete','incident'])->default('completed');

            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            $table->index('participant_id');
            $table->index('event_id');
            $table->index('user_id');

            // foreign keys (same duty connection)
            // Participants table primary key is participant_id
            $table->foreign('participant_id')->references('participant_id')->on('Participants')->onDelete('cascade');
            // Event_Duty.event_id
            $table->foreign('event_id')->references('event_id')->on('Event_Duty')->onDelete('set null');
        });

        // Attempt to add a cross-database FK to Accounts.Student(user_id) if both DBs are on same server.
        // This may fail on some setups; we catch/log the error and continue.
        $accountsDb = config('database.connections.mysql.database');
        if ($accountsDb) {
            try {
                DB::connection('duty')->statement(
                    "ALTER TABLE `Duty_Reports` ADD CONSTRAINT `fk_reports_student` FOREIGN KEY (`user_id`) REFERENCES `{$accountsDb}`.`Student`(`user_id`) ON DELETE SET NULL"
                );
            } catch (\Exception $e) {
                \Log::warning('Could not create fk_reports_student (cross-db FK): ' . $e->getMessage());
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('Duty_Reports');
    }
};
