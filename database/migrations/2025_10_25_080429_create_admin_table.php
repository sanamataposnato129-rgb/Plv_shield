<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Admin', function (Blueprint $table) {
            $table->id('admin_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('username', 100)->unique();
            $table->string('password_hash', 255);
            $table->enum('admin_type', ['Admin', 'SuperAdmin']);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('last_login')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Admin');
    }
};