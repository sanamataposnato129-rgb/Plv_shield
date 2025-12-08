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
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create('Duty_Registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('event_id');
            $table->unsignedBigInteger('student_id');
            $table->string('gmail')->nullable();
            $table->boolean('team_leader')->default(false);
            $table->enum('status', ['REGISTERED','CANCELLED','ATTENDED','NO_SHOW'])->default('REGISTERED');
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamp('attended_at')->nullable();

            $table->unique(['event_id','student_id']);
            $table->index('event_id');
            $table->index('student_id');

            // foreign key to Event_Duty (same duty DB)
            $table->foreign('event_id')->references('event_id')->on('Event_Duty')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('Duty_Registrations');
    }
};
