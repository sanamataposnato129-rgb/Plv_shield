<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('admin_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('username', 100)->unique();
            $table->string('email', 100)->unique();
            $table->string('password_hash', 255);
            $table->enum('admin_type', ['Admin', 'SuperAdmin'])->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable()->useCurrentOnUpdate();
            $table->dateTime('last_login')->nullable();
        });
    }
    public function down() {
        Schema::dropIfExists('admin');
    }
};
