<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Student', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('plv_student_id', 20)->unique();
            $table->string('email', 100)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('password_hash', 255);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('last_login')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Student');
    }
};  