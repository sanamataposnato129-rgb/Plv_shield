<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('event_duty', function (Blueprint $table) {
            $table->increments('event_id');
            $table->string('title', 100);
            $table->text('description');
            $table->date('duty_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('number_of_participants')->default(0);
            $table->enum('status', ['OPEN','IN_PROGRESS','UNDER_REVIEW','CERTIFIED','COMPLETED','CANCELLED'])->default('OPEN');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('completed_at')->nullable();
            $table->string('team_leader_name', 255)->nullable();
        });
    }
    public function down() {
        Schema::dropIfExists('event_duty');
    }
};
