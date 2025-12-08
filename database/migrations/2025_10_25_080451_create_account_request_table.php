<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Account_Request', function (Blueprint $table) {
            $table->id('request_id');
            $table->string('plv_student_id', 20)->unique();
            $table->string('email', 100)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('password_hash', 255);
            $table->enum('request_status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->foreign('reviewed_by')->references('admin_id')->on('Admin')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Account_Request');
    }
};