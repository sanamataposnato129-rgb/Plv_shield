<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('account_request', function (Blueprint $table) {
            $table->bigIncrements('request_id');
            $table->string('plv_student_id', 20)->unique();
            $table->string('email', 100)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('password_hash', 255);
            $table->enum('request_status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            // Uncomment if reviewed_by should reference admin table
            // $table->foreign('reviewed_by')->references('admin_id')->on('admin')->onDelete('set null');
        });
    }
    public function down() {
        // Drop foreign key first if it exists
        Schema::table('account_request', function (Blueprint $table) {
            // Use try/catch to avoid errors if FK doesn't exist
            try {
                $table->dropForeign(['reviewed_by']);
            } catch (\Exception $e) {}
        });
        Schema::dropIfExists('account_request');
    }
};
