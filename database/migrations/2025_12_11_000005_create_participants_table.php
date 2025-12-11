<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('participants', function (Blueprint $table) {
            $table->bigIncrements('participant_id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('plv_student_id', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->boolean('team_leader')->default(false);
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->primary('participant_id');
            $table->index('event_id', 'participants_event_id_index');
            $table->index('user_id', 'fk_participants_student');
            $table->foreign('user_id')->references('user_id')->on('student')->onDelete('set null');
        });
    }
    public function down() {
        Schema::dropIfExists('participants');
    }
};
