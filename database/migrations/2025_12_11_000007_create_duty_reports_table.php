<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('duty_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('participant_id')->nullable();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('plv_student_id', 50)->nullable();
            $table->string('summary', 255);
            $table->text('details');
            $table->json('attachments')->nullable();
            $table->enum('status', ['completed','incomplete','incident'])->default('completed');
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->primary('id');
            $table->index('participant_id', 'duty_reports_participant_id_index');
            $table->index('event_id', 'duty_reports_event_id_index');
            $table->index('user_id', 'duty_reports_user_id_index');
            $table->foreign('participant_id')->references('participant_id')->on('participants')->onDelete('cascade');
        });
    }
    public function down() {
        Schema::dropIfExists('duty_reports');
    }
};
